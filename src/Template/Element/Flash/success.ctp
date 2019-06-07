<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message success center-align teal lighten-3 white-text" onclick="this.classList.add('hidden')"><?= $message ?></div>
