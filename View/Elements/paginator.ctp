<?php

if (!isset($url)) {
    $url = array();
}
echo '<nav>';
echo '<ul class="pagination">';
echo $this->Paginator->prev('<span>&laquo;</span>', array('url' => $url, 'tag' => 'li', 'escape' => false, 'class' => 'hidden-sm hidden-xs'));
echo $this->Paginator->numbers(array('url' => $url, 'tag' => 'li', 'escape' => false, 'separator' => '', 'currentTag' => 'a', 'currentClass' => 'active'));
echo $this->Paginator->next('<span>&raquo;</span>', array('url' => $url, 'tag' => 'li', 'escape' => false));
echo '</ul>';
echo '</nav>';