<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message error center-align deep-orange darken-4 white-text" onclick="this.classList.add('hidden');"><?= $message ?></div>
