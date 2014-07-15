<h1>The SAISAI Object Structure</h1>
<p>SAISAI CMS version 1.0 provides a powerful object oriented structure which allows you to easily access SAISAI functionality within your own code.
There is a <a href="<?=user_guide_url('libraries/saisai')?>">saisai</a> object set on the main CI super object (controller object accessed using the get_instance() function).
This object allows access to your SAISAI configuration as well as attaches other useful SAISAI objects as shown below:
</p>

<ul>
	<li><strong>$this->saisai</strong> (<a href="<?=user_guide_url('libraries/saisai')?>">Saisai</a>)
	
		<ul>
			<li><strong>$this->saisai->admin</strong> (<a href="<?=user_guide_url('libraries/saisai_admin')?>">Saisai_admin</a>)</li>
			<li><strong>$this->saisai->assets</strong> (<a href="<?=user_guide_url('libraries/saisai_assets')?>">Saisai_assets</a>)</li>
			<li><strong>$this->saisai->auth</strong> (<a href="<?=user_guide_url('libraries/saisai_auth')?>">Saisai_auth</a>)</li>
			<li><strong>$this->saisai->blocks</strong> (<a href="<?=user_guide_url('libraries/saisai_blocks')?>">Saisai_blocks</a>)</li>
			<li><strong>$this->saisai->cache</strong> (<a href="<?=user_guide_url('libraries/saisai_cache')?>">Saisai_cache</a>)</li>
			<li><strong>$this->saisai->categories</strong> (<a href="<?=user_guide_url('libraries/Saisai_categories')?>">Saisai_categories</a>)</li>
			<li><strong>$this->saisai->language</strong> (<a href="<?=user_guide_url('libraries/saisai_language')?>">Saisai_language</a>)</li>
			<li><strong>$this->saisai->layouts</strong> (<a href="<?=user_guide_url('libraries/saisai_layouts')?>">Saisai_layouts</a>)</li>
			<li><strong>$this->saisai->logs</strong> (<a href="<?=user_guide_url('libraries/saisai_logs')?>">Saisai_logs</a>)</li>
			<li><strong>$this->saisai->modules</strong> (<a href="<?=user_guide_url('libraries/saisai_modules')?>">Saisai_modules</a>)</li>
			<li><strong>$this->saisai->navigation</strong> (<a href="<?=user_guide_url('libraries/saisai_navigation')?>">Saisai_navigation</a>)</li>
			<li><strong>$this->saisai->notification</strong> (<a href="<?=user_guide_url('libraries/saisai_notification')?>">Saisai_notification</a>)</li>
			<li><strong>$this->saisai->pages</strong> (<a href="<?=user_guide_url('libraries/saisai_pages')?>">Saisai_pages</a>)</li>
			<li><strong>$this->saisai->pagevars</strong> (<a href="<?=user_guide_url('libraries/saisai_pagevars')?>">Saisai_pagevars</a>)</li>
			<li><strong>$this->saisai->permissions</strong> (<a href="<?=user_guide_url('libraries/saisai_permissions')?>">Saisai_permissions</a>)</li>
			<li><strong>$this->saisai->redirects</strong> (<a href="<?=user_guide_url('libraries/saisai_redirects')?>">Saisai_redirects</a>)</li>
			<li><strong>$this->saisai->settings</strong> (<a href="<?=user_guide_url('libraries/saisai_settings')?>">Saisai_settings</a>)</li>
			<li><strong>$this->saisai->sitevars</strong> (<a href="<?=user_guide_url('libraries/saisai_sitevars')?>">Saisai_sitevars</a>)</li>
			<li><strong>$this->saisai->tags</strong> (<a href="<?=user_guide_url('libraries/saisai_tags')?>">Saisai_tags</a>)</li>
			<li><strong>$this->saisai->users</strong> (<a href="<?=user_guide_url('libraries/saisai_users')?>">Saisai_users</a>)</li>
		</ul>
	</li>
</ul>

<h3>Basic Examples</h3>
<pre class="brush:php">
// EXAMPLES if used in your controller
$page = $this->saisai->pages->create();
$nav = $this->saisai->navigation->render();
$this->saisai->cache->clear();
$this->saisai->assets->upload();
</pre>

<p class="important">All the above classes inherit from the <a href="<?=user_guide_url('libraries/saisai_base_library')?>">Saisai_base_library</a> class.</p>

<h2>Advanced Module Objects</h2>
<p>Additionally, you have access to advanced module objects if a class exists in the advanced module's libraries folder
with a naming convention of <span class="file">Saisai_{module}.php</span>. The following examples assume you have the advanced modules installed:</p>

<h3>Advanced Module Examples</h3>
<pre class="brush:php">
$posts = $this->saisai->blog->get_posts();
$this->saisai->backup->do_backup();
$this->saisai->validate->html('mypage');
$this->saisai->tester->run();
</pre>


<p class="important">The main <strong>saisai</strong> object is an Advanced Module object. Review the Advanced Module Reference in this user guide for a list of methods available for your installed advanced modules.</p>

<p class="important">The above advanced module classes inherit from the <a href="<?=user_guide_url('libraries/saisai_advanced_module')?>">Saisai_advanced_module</a> class (which itself inherits from the <a href="<?=user_guide_url('libraries/saisai_base_library')?>">Saisai_base_library</a> class).</p>
<br />

