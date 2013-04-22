<?php
Router::connect('/courses/feed', array('plugin'=>'courses', 'controller' => 'courses', 
                                     'action' => 'index', 
                                     'url' => array('ext' => 'cal')
                                ) );
