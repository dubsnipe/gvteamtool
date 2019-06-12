<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class StatsController extends AppController
{
    
    public function initialize()
    {
        parent::initialize();
        // $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    
    public function beforeFilter($event)
    {
        parent::beforeFilter($event);
        
        $user = $this->Auth->user();
        
        if (isset($user['rol']) && $user['rol'] === 'admin' ||
            isset($user['rol']) && $user['rol'] === 'manager' ) {
            $this->Auth->allow(['index', 'add', 'view', 'search', 'export', 'exportVoluntarios']);
            // return true;
            
        }elseif(isset($user['rol']) && $user['rol'] === 'user'){
            $this->Auth->allow(['index', 'view', 'search']);
            
        }elseif(!isset($user['rol'])){
            return false;
        };

        return parent::isAuthorized($user);
    }

 
public function index() {
        $helpers = array('Js' => 'Jquery');
        $brigadas = TableRegistry::getTableLocator()->get('Brigadas');
        $voluntarios = TableRegistry::getTableLocator()->get('Voluntarios');
        
        // http://www.php-dev-zone.com/2014/01/how-to-pass-controller-data-to-js-file.html
        
        
        $conditions = [
            'arrival >= ' => time(),
            'arrival <= ' => Time::now()->addMonth(2),
            'status' => true,
        ];
        
        $conditions2 = [
            'arrival <= ' => time(),
            'departure >= ' => time(),
            'status' => true,
        ];
        
        $upcomingBrigadas = $brigadas->find('all')
                        ->select(['id', 'name','arrival'])
                        // ->contain(['Voluntarios'])
                        ->where($conditions)
                        ->limit(10);         
        $upcomingBrigadasCount = $brigadas->find('all')
                        ->select(['id', 'name','arrival'])
                        // ->contain(['Voluntarios'])
                        ->where($conditions)
                        ->limit(10)
                        ->count(); 
        
        $currentBrigadas = $brigadas->find('all')
                        ->select(['id', 'name', 'arrival', 'region'])
                        ->contain(['Voluntarios'])
                        ->where($conditions2); 
        
        $currentBrigadasCount = $brigadas->find('all')
                        ->select(['id', 'name', 'arrival', 'region'])
                            ->contain(['Voluntarios'])
                        ->where($conditions2)
                        ->count(); 
            
        $brigadasAll = $brigadas->find('all')->count();
        $voluntariosAll = $voluntarios->find('all')->count();
        
        $graph = $brigadas->find();
        $graph->select(['count' => $graph->func()->count('id'), 'year' => 'YEAR(arrival)', 'month' => 'MONTH(arrival)']);
        $graph->where([
            'YEAR(arrival) >' => date('Y')-1,
            'YEAR(arrival) <' => date('Y')+1,
            'status' => true,
            ]);
        $graph->group(['YEAR(arrival)','MONTH(arrival)']);

        $graphLast = $brigadas->find();
        $graphLast->select([    
            'count' => $graphLast->func()->count('id'), 
            'year' => 'YEAR(arrival)', 
            'month' => 'MONTH(arrival)'
                            ]);
        $graphLast->where([
            'YEAR(arrival) >' => date('Y')-2,
            'YEAR(arrival) <' => date('Y'),
            'status' => true,
            ]);
        $graphLast->group(['YEAR(arrival)','MONTH(arrival)']);

        $this->set('upcomingBrigadas', $upcomingBrigadas);
        $this->set('upcomingBrigadasCount', $upcomingBrigadasCount);
        $this->set('currentBrigadas', $currentBrigadas);
        $this->set('currentBrigadasCount', $currentBrigadasCount);
        $this->set('brigadasAll', $brigadasAll);
        $this->set('voluntariosAll', $voluntariosAll);
        $this->set('graph', $graph);
        $this->set('graphLast', $graphLast);
        // $this->set('dataArray', $dataArray);
        
    }


public function search(){
    
        $brigadas = TableRegistry::getTableLocator()->get('Brigadas');
        $queryParams = $this->request->getQueryParams();
        
        $query = $brigadas
            ->find('search', ['search' => $this->request->getQueryParams()])
            ->contain(['Voluntarios']);

        $queryCancelled = $brigadas
            ->find('search', ['search' => $this->request->getQueryParams()])
            ->contain(['Voluntarios'])
            ->where(['status' => false]);
        
        $queryActive = $brigadas
            ->find('search', ['search' => $this->request->getQueryParams()])
            ->contain(['Voluntarios'])
            ->where(['status' => true]);
        
        $queryFemale = $brigadas
            ->find('search', ['search' => $this->request->getQueryParams()])
            ->where(['Brigadas.status' => 1])
            ->matching('Voluntarios', function ($q) {
                return $q->where(['Voluntarios.gender' => 'F']);
            })
            ->count();
        
        $queryMale = $brigadas
            ->find('search', ['search' => $this->request->getQueryParams()])
            ->where(['Brigadas.status' => true])
            ->matching('Voluntarios', function ($q) {
                return $q->where(['Voluntarios.gender' => 'M']);
            })
            ->count();

        // $query = $articles->find();
        // $query->select(['Articles.id', $query->func()->count('Comments.id')])
            // ->matching('Comments')
            // ->group(['Articles.id']);
        // $total = $query->count();

        // Number of team members
        $queryMembers = $brigadas
            ->find('search', ['search' => $this->request->getQueryParams()]);
        $queryMembers
            ->select(['team_members' => $queryMembers->func()->count('Voluntarios.id')])
            ->leftJoinWith('Voluntarios')
            ->group(['Brigadas.id'])
            ->where(['Brigadas.status' => true])
            ->enableAutoFields(false);
        $temp = [];
        foreach($queryMembers as $q) {
            if ($q['team_members'] > 0){
            $temp[] += $q['team_members'];
            }
        }
                
        if (count($temp)>0){
            $queryMembers = array_sum($temp) / count($temp);
        } else {
            $queryMembers = 0;
        }

        // Summary table of volunteers by state
        $queryState = $brigadas
            ->find('search', ['search' => $this->request->getQueryParams()]);
        $queryState
            ->select(['Voluntarios.state', 'Voluntarios.residenceCountry', 'total' => $queryState->func()->count('Voluntarios.state')])
            ->leftJoinWith('Voluntarios')
            ->where(['Voluntarios.residenceCountry' => 'United States'])
            ->group(['Voluntarios.state',]) // doesn't work?!
            ->order(['total' => 'DESC'])
            ->enableAutoFields(false);
        
        // Summary table of teams by type
        $queryType = $brigadas
            ->find('search', ['search' => $this->request->getQueryParams()]);
        $queryType
            ->select(['Brigadas.team_type', 'total' => $queryType->func()->count('Brigadas.team_type')])
            ->group(['Brigadas.team_type'])
            ->order(['total' => 'ASC'])
            ->enableAutoFields(false);
                
        // https://stackoverflow.com/questions/1314745/php-count-a-stdclass-object
        // https://stackoverflow.com/questions/29402180/summarize-json-data-with-php
        // Getting summary
        
        $monthArr = [];
        foreach($queryActive as $q){
            $monthArr[] = [
                        'region' => $q['region'],
                        'month' => (int)date("m", strtotime($q['arrival'])),
                        'voluntarios' => count($q['voluntarios'])
                        ];
        }

        $monthArrCancelled = [];
        foreach($queryCancelled as $q){
            $monthArrCancelled[] = [
                        'region' => $q['region'],
                        'month' => (int)date("m", strtotime($q['arrival'])),
                        'voluntarios' => count($q['voluntarios'])
                        ];
        }
        

        $monthSummary = [];
        $monthVolSummary = [];
        $summary = [];
        foreach($monthArr as $m){
            $region = $m['region'];
            if ($region == ''){
                $region = 'N/A';
            }
            if (array_key_exists($region, $monthSummary)) {
                $monthSummary[$region] += 1;
                $monthVolSummary[$region] += $m['voluntarios'];
            } else {
                $monthSummary[$region] = 1;
                $monthVolSummary[$region] = $m['voluntarios'];
            }
        }
        arsort($monthSummary);
        
        $teamSum = array_sum($monthSummary); 
        $volSum = array_sum($monthVolSummary); 
        $summary = array_merge_recursive($monthSummary, $monthVolSummary);
        arsort($monthVolSummary);
        
        $summary2 = [];
        foreach($summary as $key=>$s){
            $s['region'] = $key;
            $s['brigadas'] = $s[0];
            $s['voluntarios'] = $s[1];
            unset($s[0]);
            unset($s[1]);
            $summary2[] = $s;
        }
        
        /////////////

        $monthSummaryCancelled = [];
        $monthVolSummaryCancelled = [];
        $summaryCancelled = [];
        foreach($monthArrCancelled as $m){
            $region = $m['region'];
            if ($region == ''){
                $region = 'N/A';
            }
            if (array_key_exists($region, $monthSummaryCancelled)) {
                $monthSummaryCancelled[$region] += 1;
                $monthVolSummaryCancelled[$region] += $m['voluntarios'];
            } else {
                $monthSummaryCancelled[$region] = 1;
                $monthVolSummaryCancelled[$region] = $m['voluntarios'];
            }
        }
        arsort($monthSummaryCancelled);
        
        $teamSumCancelled = array_sum($monthSummaryCancelled); 
        $volSumCancelled = array_sum($monthVolSummaryCancelled); 
        $summaryCancelled = array_merge_recursive($monthSummaryCancelled, $monthVolSummaryCancelled);
        arsort($monthVolSummaryCancelled);
        
        $summary2Cancelled = [];
        foreach($summaryCancelled as $key=>$s){
            $s['region'] = $key;
            $s['brigadas'] = $s[0];
            $s['voluntarios'] = $s[1];
            unset($s[0]);
            unset($s[1]);
            $summary2Cancelled[] = $s;
        }


        $this->set('queryMale', $queryMale);
        $this->set('queryFemale', $queryFemale);
        $this->set('queryType', $queryType);
        $this->set('queryMembers', $queryMembers);
        $this->set('queryState', $queryState);

        $this->set('teamSum', $teamSum);
        $this->set('volSum', $volSum);
        $this->set('monthSummary', $monthSummary);
        $this->set('monthVolSummary', $monthVolSummary);
        $this->set('summary', $summary);
        $this->set('summary2', $summary2);
        
        $this->set('teamSumCancelled', $teamSumCancelled);
        $this->set('volSumCancelled', $volSumCancelled);
        $this->set('monthSummaryCancelled', $monthSummaryCancelled);
        $this->set('monthVolSummaryCancelled', $monthVolSummary);
        $this->set('summaryCancelled', $summaryCancelled);
        $this->set('summary2Cancelled', $summary2Cancelled);

        $this->set('queryParams', $queryParams);
}


public function export()
{
    $brigadas = TableRegistry::getTableLocator()->get('Brigadas');
    $data = $brigadas->find('search', ['search' => $this->request->getQueryParams()]);
    
    $data->select(['name', 'status', 'gvCode', 'team_type', 'arrival', 'departure', 'region', 'project',
        'voluntarios' => $data->func()->count('Voluntarios.id')
    ])
    ->leftJoinWith('Voluntarios')
    ->group(['Brigadas.id'])
    ->enableAutoFields(false); // Prior to 3.4.0 use autoFields(true);
    
    $_serialize = 'data';
    $_header = ['name', 'status', 'gvCode', 'team_type', 'arrival', 'departure', 'region', 'project', 'voluntarios'];

    $this->viewBuilder()->setClassName('CsvView.Csv');
    $this->set(compact('data', '_serialize', '_header'));
}

public function exportVoluntarios()
{
    $voluntarios = TableRegistry::getTableLocator()->get('Voluntarios');
    $data = $voluntarios
            ->find('search', ['search' => $this->request->getQueryParams()])
            ->select(['firstName', 'middleName', 'lastName', 'gender', 'city', 'address', 'residenceCountry', 'email']);

    $_serialize = 'data';
    $_header = ['First Name', 'Middle Name', 'Last Name', 'Gender', 'City', 'Address', 'Country', 'Email'];

    $this->viewBuilder()->setClassName('CsvView.Csv');
    $this->set(compact('data', '_serialize', '_header'));
}

    
}
