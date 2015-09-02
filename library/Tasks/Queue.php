<?php
/*
 * Copyright 2012-2015 Damien Seguy – Exakat Ltd <contact(at)exakat.io>
 * This file is part of Exakat.
 *
 * Exakat is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Exakat is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Exakat.  If not, see <http://www.gnu.org/licenses/>.
 *
 * The latest code can be found at <http://exakat.io/>.
 *
*/


namespace Tasks;

class Queue extends Tasks {
    public function run(\Config $config) {
        $this->config = $config;
        
        display('Adding "'.$config->project.'" to the queue.');
        
        if (file_exists($config->projects_root.'/projects/'.$config->project.'/report/')) {
            display('Cleaning the project first');
            $clean = new Clean();
            $clean->run($config);
        }

        display('Adding '.$config->project.' to the queue');
        $queuePipe = fopen('/tmp/onepageQueue', 'w');
        fwrite($queuePipe, $config->project."\n");
        fclose($queuePipe);

        display('Done');
    }
}

?>