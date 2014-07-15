<h1>Inline Editing</h1>
<p>Inline editing allows users to quickly modify module information within the context of the website. This is accomplished by using
either the <a href="<?=user_guide_url('helpers/saisai_helper')?>">saisai_edit</a> or the <a href="<?=user_guide_url('helpers/saisai_helper')?>">saisai_var</a> function with the latter
specific to pages that are completely editable (and not just module data).
</p>

<h4>saisai_var example</h4>
<pre class="brush: php">
// short version
&lt;?=saisai_var('myvarname')?&gt;

// with default value
&lt;?=saisai_var('myvarname', 'Default Value Goes Here')?&gt;

// with default value and turns off the inline editing
&lt;?=saisai_var('myvarname', 'Default Value Goes Here', FALSE)?&gt;
</pre>


<h4>saisai_edit example</h4>
<pre class="brush: php">
// short version
&lt;?=saisai_edit($article)?&gt;

// long version
&lt;?=saisai_edit($article->id, 'Edit article: '.$article->title, 'articles', 10, 10)?&gt;

// with create
&lt;?=saisai_edit('create', 'articles')?&gt;

// with create and initialization values
&lt;?=saisai_edit('create|author_id=1', 'articles')?&gt;
</pre>

<p>For inline editing to work, you must be logged into SAISAI and have the proper permissions to edit the page or module information.
A <span style="background: transparent url(<?=img_path('ico_pencil.png', SAISAI_FOLDER)?>) no-repeat; display: inline-block; height: 16px; width: 16px;"></span> pencil icon
will appear over editable areas when the editing for the page is toggled on. Clicking on the icon will overlay a form over your page to edit the values in context.</p>

<h2>Page Inline Editing</h2>
<p>Page inline editing allows you to edit the values of variables used in the page.
A SAISAI logo will be displayed in the upper right area of the page that can slide out and provide you
the ability to toggle inline editing, publish status and caching. Clicking the inline editing pencil will toggle inline editing on.</p>
<img src="<?=img_path('screens/inline_editing_toolbar.jpg', SAISAI_FOLDER)?>" class="screen" />

<h2>Module Inline Editing</h2>
<p>For those pages that may not be editible, you can still allow for module data to be edited (e.g. news items).
The top right area <strong>will not</strong> have the controls for page publish status, caching or layouts and will look like the following:</p>
<img src="<?=img_path('screens/inline_editing.jpg', SAISAI_FOLDER)?>" class="screen" />

<p>Clicking the pencil will reveal the form to edit the module information.</p>
<img src="<?=img_path('screens/inline_editing_form.jpg', SAISAI_FOLDER)?>" class="screen" />

<h2>Disabling Inline Editing</h2>
<p>To disable inline editing for a static view file, set the "SAISAIIFY" constant to FALSE in your view file like so:</p>
<pre class="brush: php">
&lt;?php define('SAISAIIFY', FALSE); ?&gt;
</pre>