<h1>SAISAI Constants</h1>
<p>In addition to the <a href="http://ellislab.com/codeigniter/user-guide/general/reserved_names.html" target="_blank">CodeIgniter constants</a>, SAISAI CMS provides the following:</p>

<ul>
	<li><strong>SAISAI_VERSION</strong>: The current version number of SAISAI</li>
	<li><strong>SAISAI_FOLDER</strong>: The SAISAI module folder name. The value is <dfn>saisai</dfn></li>
	<li><strong>SAISAI_PATH</strong>: The full server path to the SAISAI module folder</li>
	<li><strong>SAISAI_ROUTE</strong>: The route to use to access the SAISAI CMS. The default value is <dfn>saisai/</dfn></li>
	<li><strong>USE_SAISAI_ROUTES</strong>: A boolean value automatically generated based on the URI location which determines whether to includes the SAISAI routes in a request or not</li>
	<li><strong>SAISAI_ADMIN</strong>: This is only set in a controller that extends the <a href="<?=user_guide_url('libraries/saisai_base_controller')?>">Saisai_base_controller</a> and can be used to assess if the current page is an admin page or not.</li>

	<li><strong>MODULES_FOLDER</strong>: The folder path relative to the <span class="file">saisai/application</span> directory. The value is <span class="file">'../modules'</span></li>
	<li><strong>MODULES_PATH</strong>: The full server path the module folder</li>
	<li><strong>MODULES_FROM_APPCONTROLLERS</strong>: The modules folder relative to the application controllers directory</li>
	<li><strong>MODULES_WEB_PATH</strong>: The web path to the modules folder</li>

	<li><strong>WEB_FOLDER</strong>: The name of the web folder of the SAISAI installation</li>
	<li><strong>WEB_ROOT</strong>: The full server path to the web directory</li>
	<li><strong>WEB_PATH</strong>: The web path to the SAISAI installation on the server (if saisai is installed in a subfolder)</li>
	<li><strong>BASE_URL</strong>: The web path in which all site urls are based. Is also used as the <dfn>$config['base_url']</dfn> value in the <span class="file">saisai/application/config/config.php</span> file</li>
</ul>

<h2>Constants for Advanced Modules</h2>
<p>When creating an advanced module, you should also create a constants file at <span class="file">/saisai/modules/{module}/config/{module}_constnats.php</span>
with at least the following constants:</p>
<pre class="brush:php">
define('{MY_MODULE}_VERSION', '1.0');
define('{MY_MODULE}_FOLDER', 'my_module');
define('{MY_MODULE}_PATH', MODULES_PATH.{MY_MODULE}_FOLDER.'/');
</pre>