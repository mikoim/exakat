<?php
/*
 * Copyright 2012-2016 Damien Seguy – Exakat Ltd <contact(at)exakat.io>
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

class Upgrade extends Tasks {
    public function run(\Config $config) {
    /*
        if (!$config->isPhar) {
            print "This command can only upgrade exakat.phar.\n  If you are running exakat from source, do a git pull\n";
            exit;
        }
        */

        $options = array(
            'http'=>array(
                'method' => 'GET',
                'header' => "User-Agent: exakat-" .\Exakat::VERSION
            )
        );

        $context = stream_context_create($options);
        $html = file_get_contents('http://dist.exakat.io/versions/index.php', true, $context);

        if (empty($html)) {
            print "Unable to check last version. Try again later.\n";
            exit;
        }
        
        preg_match('/Download exakat version (\d+\.\d+\.\d+) \(Latest\)/s', $html, $r);
        
        if (version_compare(\Exakat::VERSION, $r[1]) < 0) {
            print "This needs some updating (Current : ".\Exakat::VERSION.", Latest: $r[1])\n";
            if ($config->update === true) {
                print "  Updating to latest version.\n";
                preg_match('#<pre id="sha256">(.*?)</pre>#', $html, $r);

                $phar = file_get_contents('http://dist.exakat.io/versions/index.php?file=latest');
                $sha256 = $r[1];
                
                if (hash('sha256', $phar) !== $sha256) {
                    print "Error while checking exakat.phar's checksum. Aborting update. Please, try again\n";
                    exit;
                }
                
                file_put_contents('exakat.1.phar', $phar);
                print "Setting up exakat.phar\n";
                rename('exakat.1.phar', 'exakat.phar');
                exit;
            } else {
                print "  You may run this command with -u option to upgrade to the latest exakat version.\n";
                exit;
            }
        } elseif (version_compare(\Exakat::VERSION, $r[1]) === 0) {
            print "This is the latest version (".\Exakat::VERSION.")\n";
        } else {
            print "This version is ahead of the latest publication (Current : ".\Exakat::VERSION.", Latest: $r[1])\n";
        }
    }
}

?>