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

use Everyman\Neo4j\Client,
    Everyman\Neo4j\Gremlin\Query;

class OnepageReport implements Tasks {
    public function run(\Config $config) {
        $project = $config->project;

        $client = new Client();
        
        $result = new \Stdclass();
        $analyzers = \Analyzer\Analyzer::getThemeAnalyzers('OneFile');
        
        foreach($analyzers as $analyzer) {
            $a = \Analyzer\Analyzer::getInstance($analyzer, $client);
            $results = $a->getArray();
            if (!empty($results)) {
                $result->{$a->getDescription()->getName()} = $results;
            }
        }

        file_put_contents($config->projects_root.'/projects/'.$project.'/onepage.json', json_encode($result));
    }
}

?>