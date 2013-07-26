<?php 

Router::connect(
    '/courses/:action/*',
    array('plugin' => 'courses', 'controller' => 'courses', 'action' => 'index')
);


Router::connect(
    '/series/:action/*',
    array('plugin' => 'courses', 'controller' => 'courseSeries', 'action' => 'index')
);

Router::connect(
    '/lessons/:action/*',
    array('plugin' => 'courses', 'controller' => 'courseLessons', 'action' => 'index')
); 
