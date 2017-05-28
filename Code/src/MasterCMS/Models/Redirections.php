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

	class Redirections {
		public function php($value)
		{
			header("Location: {$value}");
		}

		public function js($value, $time = false)
		{
			if (!$time) {
				echo "<script>window.location = '{$value}';</script>";
			} else {
				echo "<script>setTimeout(function(){window.location = '{$value}';}, {$time});</script>";
			}
		}

		public function html($value, $time = false)
		{
			if (!$time) {
				echo "<meta http-equiv=\"refresh\" content=\"0; url={$value}\"/>";
			} else {
				echo "<meta http-equiv=\"refresh\" content=\"{$time}; url={$value}\"/>";
			}
		}
	}

?>