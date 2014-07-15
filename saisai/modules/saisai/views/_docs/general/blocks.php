<h1>Blocks</h1>
<p>Blocks in SAISAI CMS are repeatable areas of your site such as headers, footers, callouts and promotional areas.</p>

<p>Programmatically, you can use the <a href="<?=user_guide_url('helpers/saisai_helper#func_saisai_block')?>">saisai_block</a> helper function to render the contents of the block
or you can access the instantiated <a href="<?=user_guide_url('libraries/saisai_blocks')?>">Saisai_blocks</a> object like so:</p>
<pre class="brush:php">
// short way
echo saisai_block('my_block');

// long way 
echo $this->saisai->blocks->render('my_block');
</pre>

<p>Or you can use the array syntax if more options are required for rendering:</p>
<pre class="brush:php">
// short way
echo saisai_block(array('view' => 'my_block', 'only_views' => TRUE));

// long way 
echo $this->saisai->blocks->render(array('view' => 'my_block', 'only_views' => TRUE));
</pre>


<h2>Static vs. CMS Blocks</h2>
<p>Similar to pages, blocks can exist statically or be maintained in the CMS. Static blocks are located in the <span class="file">application/views/_blocks/</span> folder and operate like a normal view file. 
Static blocks can be uploaded into the CMS to be editable. The upload process will "try" and translate any PHP syntax into the <a href="<?=user_guide_url('general/template-parsing')?>">templating syntax</a>. 
</p>
<p>By default, if the saisai configuration's <dfn>saisai_mode</dfn> is set to AUTO, then it will first look in the database for a block with the specified name. If no block is found in the CMS, it will then look in the static
<span class="file">applications/views/_blocks/</span> view folder unless the parameter "only_views" is set to TRUE, in which case it will only look in the <dfn>_blocks</dfn> folder.
</p>