<table border="0" cellspacing="0" cellpadding="0" class="toc_table">
	<tbody>
		<tr>
			<td class="td">
				
				<?php if ($site_docs) : ?>
				<h3>Site Reference</h3>
				<ul>
					<li><a href="<?=user_guide_url('site')?>">Site Documentation</a></li>
				</ul>
				<?php endif; ?>
				
				<ul>
					<li><a href="<?=user_guide_url()?>">User Guide Home</a></li>
				</ul>
				
				<h3>Basic Info</h3>
				<ul>
					<li><a href="<?=user_guide_url('general/license')?>">License Agreement</a></li>
					<li><a href="<?=user_guide_url('general/credits')?>">Credits</a></li>
					<li><a href="<?=user_guide_url('general/contribute')?>">Contribute</a></li>
				</ul>

				<h3>Installation</h3>
				<ul>
					<li><a href="<?=user_guide_url('installation/installing')?>">Installing SAISAI CMS</a></li>
					<li><a href="<?=user_guide_url('installation/requirements')?>">Server Requirements</a></li>
					<li><a href="<?=user_guide_url('installation/db-setup')?>">Database Setup</a></li>
					<li><a href="<?=user_guide_url('installation/troubleshooting')?>">Troubleshooting</a></li>
					<li><a href="<?=user_guide_url('installation/configuration')?>">Configuring SAISAI CMS</a></li>
				</ul>
				
				<h3>Introduction</h3>
				<ul>
					<li><a href="<?=user_guide_url('introduction/what-is-saisai')?>">What is SAISAI CMS?</a></li>
					<li><a href="<?=user_guide_url('introduction/whats-new')?>">New In SAISAI CMS 1.0</a></li>
					<?php /* ?><li><a href="<?=user_guide_url('introduction/demo-site')?>">The Demo Site</a></li><?php */ ?>
					<li><a href="<?=user_guide_url('introduction/interface')?>">The CMS Interface</a></li>
				</ul>
				
				<h3>Additional Resources</h3>
				<ul>
					<li><a href="http://www.getsaisaicms.com/blog">SAISAI CMS's Blog</a></li>
					<li><a href="http://www.thedaylightstudio.com/the-whiteboard/categories/saisai-cms">Daylight's Blog</a></li>
					<li><a href="http://codeigniter.com">CodeIgniter Website</a></li>
				</ul>

			</td>
			<td class="td_sep">
				
				<h3>General Topics</h3>
				<ul>
					<li><a href="<?=user_guide_url('general/saisai-object-structure')?>">The SAISAI Object Structure</a></li>
					<li><a href="<?=user_guide_url('general/opt-in-controllers')?>">Opt-in Controller Development</a></li>
					<li><a href="<?=user_guide_url('general/inline-editing')?>">Inline Editing</a></li>
					<li><a href="<?=user_guide_url('general/pages-variables')?>">Pages &amp; Variables</a></li>
					<li><a href="<?=user_guide_url('general/site-variables')?>">Site Variables</a></li>
					<li><a href="<?=user_guide_url('general/template-parsing')?>">Template Parsing</a></li>
					<li><a href="<?=user_guide_url('general/views')?>">Views</a></li>
					<li><a href="<?=user_guide_url('general/layouts')?>">Layouts</a></li>
					<li><a href="<?=user_guide_url('general/navigation')?>">Navigation</a></li>
					<li><a href="<?=user_guide_url('general/blocks')?>">Blocks</a></li>
					<li><a href="<?=user_guide_url('general/assets')?>">Assets</a></li>
					<li><a href="<?=user_guide_url('general/user-management')?>">User Management</a></li>
					<li><a href="<?=user_guide_url('general/models')?>">Models</a></li>
					<li><a href="<?=user_guide_url('general/forms')?>">Forms</a></li>
					<li><a href="<?=user_guide_url('general/tags-categories')?>">Tags &amp; Categories</a></li>
					<li><a href="<?=user_guide_url('general/dashboards')?>">Dashboards</a></li>
					<li><a href="<?=user_guide_url('general/redirects')?>">Redirects</a></li>
					<li><a href="<?=user_guide_url('general/javascript')?>">Javascript</a></li>
					<li><a href="<?=user_guide_url('general/caching')?>">Caching</a></li>
					<li><a href="<?=user_guide_url('general/security')?>">Security</a></li>
					<li><a href="<?=user_guide_url('general/localization')?>">Language/Localization</a></li>
					<li><a href="<?=user_guide_url('general/constants')?>">SAISAI Constants</a></li>
					<li><a href="<?=user_guide_url('general/configs-settings')?>">Configs &amp; Settings</a></li>
					<li><a href="<?=user_guide_url('general/environments')?>">Environments</a></li>
					<li><a href="<?=user_guide_url('general/logs')?>">Logs</a></li>
					<li><a href="<?=user_guide_url('general/migrations')?>">Migrations</a></li>
					<li><a href="<?=user_guide_url('general/extending')?>">Extending SAISAI</a></li>
				</ul>
			</td>
			<td class="td_sep">
				<h3>SAISAI Specific Classes</h3>
				<ul>
					<li><a href="<?=user_guide_url('libraries/saisai')?>">Saisai</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_admin')?>">Saisai Admin Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_advanced_module')?>">Saisai Advanced Module Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_assets')?>">Saisai Assets Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_auth')?>">Saisai Auth Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_base_controller')?>">Saisai Base Controller Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_base_library')?>">Saisai Base Library Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_blocks')?>">Saisai Blocks Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_cache')?>">Saisai Cache Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_categories')?>">Saisai Categories Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_layouts')?>">Saisai Layouts Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_language')?>">Saisai Language Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_logs')?>">Saisai Logs Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_modules')?>">Saisai Modules Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_navigation')?>">Saisai Navigation Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_notification')?>">Saisai Notification Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_pages')?>">Saisai Pages Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_pagevars')?>">Saisai Pagevars Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_permissions')?>">Saisai Permissions Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_redirects')?>">Saisai Redirects Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_sitevars')?>">Saisai Sitevars Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_tags')?>">Saisai Tags Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_users')?>">Saisai Users Class</a></li>
				</ul>

				<h3>Extended Base Classes</h3>
				<ul>
					<li><a href="<?=user_guide_url('libraries/my_db_mysql_driver')?>">MY_DB_mysql_driver Class</a></li>
					<li><a href="<?=user_guide_url('libraries/my_db_mysql_result')?>">MY_DB_mysql_result Class</a></li>
					<li><a href="<?=user_guide_url('libraries/my_hooks')?>">MY_Hooks Class</a></li>
					<li><a href="<?=user_guide_url('libraries/my_image_lib')?>">MY_Image_lib Class</a></li>
					<li><a href="<?=user_guide_url('libraries/my_model')?>">MY_Model Class</a></li>
					<li><a href="<?=user_guide_url('libraries/my_parser')?>">MY_Parser Class</a></li>
				</ul>

			</td>
			<td class="td_sep">
				<h3>Model Classes</h3>
				<ul>
					<li><a href="<?=user_guide_url('libraries/my_model')?>">MY_Model Class</a></li>
					<li><a href="<?=user_guide_url('libraries/base_module_model')?>">Base_module_model Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_archives_model')?>">Saisai_archives_model Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_assets_model')?>">Saisai_assets_model Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_blocks_model')?>">Saisai_blocks_model Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_categories_model')?>">Saisai_categories_model Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_logs_model')?>">Saisai_logs_model Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_navigation_model')?>">Saisai_navigation_model Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_navigation_groups_model')?>">Saisai_navigation_groups_model Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_pages_model')?>">Saisai_pages_model Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_pagevariables_model')?>">Saisai_pagevariables_model Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_permissions_model')?>">Saisai_permissions_model Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_relationships_model')?>">Saisai_relationships_model Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_settings_model')?>">Saisai_settings_model Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_sitevariables_model')?>">Saisai_sitevariables_model Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_tags_model')?>">Saisai_tags_model Class</a></li>
					<li><a href="<?=user_guide_url('libraries/saisai_users_model')?>">Saisai_users_model Class</a></li>
				</ul>
				
				<h3>General Classes</h3>
				<ul>
					<li><a href="<?=user_guide_url('libraries/asset')?>">Asset Class</a></li>
					<li><a href="<?=user_guide_url('libraries/curl')?>">Curl Class</a></li>
					<li><a href="<?=user_guide_url('libraries/data_table')?>">Data Table Class</a></li>
					<li><a href="<?=user_guide_url('libraries/form')?>">Form Class</a></li>
					<li><a href="<?=user_guide_url('libraries/form_builder')?>">Form Builder Class</a></li>
					<li><a href="<?=user_guide_url('libraries/inspection')?>">Inspection Class</a></li>
					<li><a href="<?=user_guide_url('libraries/menu')?>">Menu Class</a></li>
					<li><a href="<?=user_guide_url('libraries/validator')?>">Validator Class</a></li>
				</ul>

				<h3>3rd Party Classes</h3>
				<ul>
					<li><a href="<?=user_guide_url('libraries/cache')?>">Cache Class</a></li>
					<li><a href="<?=user_guide_url('libraries/modular_extensions')?>">Modular Extensions - HMVC Class</a></li>
					<li><a href="<?=user_guide_url('libraries/simplepie')?>">Simplepie Class</a></li>
				</ul>
				

			</td>
			<td class="td_sep">
			
				<h3>SAISAI Specific Helpers</h3>
				<ul>
					<li><a href="<?=user_guide_url('helpers/saisai_helper')?>">SAISAI helper</a></li>
					<li><a href="<?=user_guide_url('helpers/my_helper')?>">MY helper</a></li>
				</ul>
				<h3>General Helpers</h3>
				<ul>
					<li><a href="<?=user_guide_url('helpers/ajax_helper')?>">Ajax helper</a></li>
					<li><a href="<?=user_guide_url('helpers/asset_helper')?>">Asset helper</a></li>
					<li><a href="<?=user_guide_url('helpers/browser_helper')?>">Browser helper</a></li>
					<li><a href="<?=user_guide_url('helpers/compatibility_helper')?>">Compatibility helper</a></li>
					<li><a href="<?=user_guide_url('helpers/convert_helper')?>">Convert helper</a></li>
					<li><a href="<?=user_guide_url('helpers/format_helper')?>">Format helper</a></li>
					<li><a href="<?=user_guide_url('helpers/google_helper')?>">Google helper</a></li>
					<li><a href="<?=user_guide_url('helpers/scraper_helper')?>">Scraper helper</a></li>
					<li><a href="<?=user_guide_url('helpers/session_helper')?>">Session helper</a></li>
					<li><a href="<?=user_guide_url('helpers/simplepie_helper')?>">Simplepie helper</a></li>
					<li><a href="<?=user_guide_url('helpers/utility_helper')?>">Utility helper</a></li>
					<li><a href="<?=user_guide_url('helpers/validator_helper')?>">Validator helper</a></li>
				</ul>
				
				<h3>3rd Party Helpers</h3>
				<ul>
					<li><a href="<?=user_guide_url('helpers/markdown_helper')?>">Markdown helper</a></li>
				</ul>
				
				<h3>Extended Helpers</h3>
				<ul>
					<li><a href="<?=user_guide_url('helpers/my_array_helper')?>">MY_array helper</a></li>
					<li><a href="<?=user_guide_url('helpers/my_date_helper')?>">MY_date helper</a></li>
					<li><a href="<?=user_guide_url('helpers/my_directory_helper')?>">MY_directory helper</a></li>
					<li><a href="<?=user_guide_url('helpers/my_file_helper')?>">MY_file helper</a></li>
					<li><a href="<?=user_guide_url('helpers/my_html_helper')?>">MY_html helper</a></li>
					<li><a href="<?=user_guide_url('helpers/my_language_helper')?>">MY_language helper</a></li>
					<li><a href="<?=user_guide_url('helpers/my_string_helper')?>">MY_string helper</a></li>
					<li><a href="<?=user_guide_url('helpers/my_url_helper')?>">MY_url helper</a></li>
				</ul>
			</td>
			<td class="td_sep">
				<h3>Modules</h3>
				<ul>
					<li><a href="<?=user_guide_url('modules')?>">Modules Overview</a></li>
					<li><a href="<?=user_guide_url('modules/simple')?>">Simple Modules</a></li>
					<li><a href="<?=user_guide_url('modules/advanced')?>">Advanced Modules</a></li>
					<li><a href="<?=user_guide_url('modules/hooks')?>">Module Hooks</a></li>
					<li><a href="<?=user_guide_url('modules/tools')?>">Module Tools</a></li>
					<li><a href="<?=user_guide_url('modules/generate')?>">Generate Module Files</a></li>
					<li><a href="<?=user_guide_url('modules/tutorial')?>">Tutorial: Creating Simple Modules</a></li>
				</ul>

				<?php if (!empty($modules)) : ?>
				<h3>Advanced Module References</h3>
				<ul>
				<?php foreach($modules as $uri => $module) : ?>
					<?php if ($uri != 'saisai'): ?>
					<li><a href="<?=user_guide_url('modules/'.$uri)?>"><?=$module?></a></li>
					<?php endif; ?>
				<?php endforeach; ?>
				</ul>
				<?php endif; ?>
				
				
			</td>
		</tr>
	</tbody>
</table>