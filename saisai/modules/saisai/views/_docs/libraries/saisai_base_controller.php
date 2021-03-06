<h1>Saisai Base Controller Class</h1>
<p>The <dfn>Saisai_base_controller</dfn> Class should be used for CMS controllers. It is in charge of initilizing the <dfn>Saisai_admin</dfn> class
which is used to display the various aspects of the CMS. Below is an example of how to use it for your own CMS controllers.</p>

<h3>Example</h3>
<pre class="brush:php">
require_once(SAISAI_PATH.'/libraries/Saisai_base_controller.php');

class My_module_controller extends Saisai_base_controller {
...
</pre>