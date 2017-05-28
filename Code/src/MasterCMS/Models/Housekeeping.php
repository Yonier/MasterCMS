<?php
    
    /**
     *
     *   MasterCMS
     *
     *   Copyright (c) 2017 MasterCMS
     *
     *   @author <Denzel Code>
     *   -------------------------------------------------------------------------
     *   Licensed under the Apache License, Version 2.0 (the "License");
     *   you may not use this file except in compliance with the License.
     *   You may obtain a copy of the License at
     *
     *       http://www.apache.org/licenses/LICENSE-2.0
     *
     *   Unless required by applicable law or agreed to in writing, software
     *   distributed under the License is distributed on an "AS IS" BASIS,
     *   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
     *   See the License for the specific language governing permissions and
     *   limitations under the License.
     *   -------------------------------------------------------------------------
    */
   
    namespace MasterCMS\Models;

    use MasterCMS\Config\{Config, Connection};

    class Housekeeping {

        private $con;
        private $users;

        public function __construct()
        {
            $this->con = new Connection();
            $this->users = new Users();
        }

        public function submitMessage($user_id, $message, $time)
        {
            $query = $this->con->query("INSERT INTO dashboard_messages (user_id, message, timestamp) VALUES ('{$user_id}', '{$message}', '{$time}')");
            if ($query) {
                return true;
            } else {
                return false;
            }
        }

        public function deleteMessage($id)
        {
            if (is_numeric($id)) {
                $query = $this->con->query("DELETE FROM dashboard_messages WHERE id = '{$id}'");
                if ($query) {
                    return true;
                } else {
                    return false;
                }
            } else if ($id == '*') {
                $query = $this->con->query("DELETE FROM dashboard_messages");
                if ($query) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        public function submitLog($user_id, $content, $time)
        {
            $query = $this->con->query("INSERT INTO dashboard_logs (user_id, content, timestamp) VALUES ('{$user_id}', '{$content}', '{$time}')");
            if ($query) {
                return true;
            } else {
                return false;
            }
        }

        public function deleteLog($id)
        {
            if (is_numeric($id)) {
                $query = $this->con->query("DELETE FROM dashboard_logs WHERE id = '{$id}'");
                if ($query) {
                    return true;
                } else {
                    return false;
                }
            } else if ($id == '*') {
                $query = $this->con->query("DELETE FROM dashboard_logs");
                if ($query) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        public function submitBan($ban_type, $value, $reason, $expire, $added_by, $added_date)
        {
            if ($ban_type == 'user') {
                $query = $this->con->query("SELECT * FROM users WHERE username = '{$value}'");
                if ($this->con->num_rows($query)) {
                    $query = $this->con->query("SELECT * FROM bans WHERE value = '{$value}'");
                    if (!$this->con->num_rows($query)) {
                        $query = $this->con->query("INSERT INTO bans (bantype, value, reason, expire, added_by, added_date) VALUES ('{$ban_type}', '{$value}', '{$reason}', '{$expire}', '{$added_by}', '{$added_date}')");
                        return $query;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else if ($ban_type == 'ip') {
                $query = $this->con->query("SELECT * FROM users WHERE ip_last = '{$value}' OR ip_reg = '{$value}'");
                if ($this->con->num_rows($query)) {
                    $query = $this->con->query("SELECT * FROM bans WHERE value = '{$value}'");
                    if (!$this->con->num_rows($query)) {
                        $query = $this->con->query("INSERT INTO bans (bantype, value, reason, expire, added_by, added_date) VALUES ('{$ban_type}', '{$value}', '{$reason}', '{$expire}', '{$added_by}', '{$added_date}')");
                        return $query;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }

        public function deleteBan($id)
        {
            $query = $this->con->query("SELECT * FROM bans WHERE id = '{$id}'");
            if ($this->con->num_rows($query)) {
                $query = $this->con->query("DELETE FROM bans WHERE id = '{$id}'");
                return $query;
            } else {
                return false;
            }
        }

        public function __destruct()
        {
            $this->con->close();
        }
        
    }

?>