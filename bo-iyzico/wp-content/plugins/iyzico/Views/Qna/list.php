<div class="wrap nosubsub">
	<h2>All Q&A's</h2>
	<?php
	if ( $model['qnaAdded'] ) { ?>
		<div id="setting-error-settings_updated" class="updated settings-error"> <p><strong>Question and Answer added.</strong></p></div>
	<?php } ?>
	<div id="notificationBar" style="display: none" class="updated settings-error"> <p><strong></strong></p></div>

	<div id="col-container">
	<div id="col-right">
		<div class="col-wrap">
			<form id="posts-filter" action="<?php echo(self::getPageRoute('qna_question_delete'))?>" method="post">
				<div class="tablenav top">
					<div class="alignleft actions bulkactions">
						<label for="bulk-action-selector-bottom" class="screen-reader-text">Select filter action</label>
						<select name="filter-by-parent" class="filter-action" id="filter-action-selector">
							<option value="<?=self::generateFilterUrl()?>">Filter by Parent</option>
							<?php
							foreach($model['allCategories'] as $index=>$category)
							{ ?>
								<option class="level-<?=$index?>" <?php if (isset ($_GET['parent']) && $_GET['parent'] == $category['ID']) {echo('selected="selected"');}?> value="<?=self::generateFilterUrl($category['ID'])?>"><?=$category['Name']?></option>
							<?php
							}
							?>
						</select>
					</div>

					<div class="tablenav-pages <?php if($model['pagination']['pageCount'] == 1) echo('one-page');?>">
						<span class="displaying-num"><?php echo($model['qnaCount']) ?> item(s)</span>
						<span class="pagination-links">
							<a class="first-page <?php if($model['pagination']['currentPage'] == 1) echo('disabled');?>" title="Go to the first page" href="<?php echo(self::generatePaginationUrl(1)); ?>">«</a>
							<a class="prev-page <?php if($model['pagination']['currentPage'] == 1 ) echo('disabled');?>" title="Go to the previous page" href="<?php if ($model['pagination']['currentPage'] > 1 ) { echo(self::generatePaginationUrl($model['pagination']['currentPage']-1)); } else { echo(self::generatePaginationUrl(1)); }; ?>">‹</a>
							<span class="paging-input">
								<label for="current-page-selector" class="screen-reader-text">Select Page</label>
								<span class="total-pages"><?php echo($model['pagination']['currentPage']); ?></span> of <span class="total-pages"><?php echo($model['pagination']['pageCount']); ?></span>
							</span>
							<a class="next-page <?php if($model['pagination']['currentPage'] == $model['pagination']['pageCount']) echo('disabled');?>" title="Go to the next page" href="<?php if($model['pagination']['currentPage'] < $model['pagination']['pageCount']) {echo(self::generatePaginationUrl($model['pagination']['currentPage']+1));}else{echo(self::generatePaginationUrl($model['pagination']['currentPage']));}?>">›</a>
							<a class="last-page <?php if($model['pagination']['currentPage'] == $model['pagination']['pageCount']) echo('disabled');?>" title="Go to the last page" href="<?php echo(self::generatePaginationUrl($model['pagination']['pageCount'])); ?>">»</a></span>
					</div>
					<br class="clear">
				</div>
			<table class="wp-list-table widefat fixed tags">
				<thead>
					<tr>
						<th scope="col" id="cb" class="manage-column column-cb check-column">
							<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
							<input id="cb-select-all-1" type="checkbox">
						</th>
						<th scope="col" id="name" class="manage-column column-name sortable desc">
							<a href="#">
								<span>Name</span>
								<span class="sorting-indicator"></span>
							</a>
						</th>
						<th scope="col" class="manage-column column-name sortable desc">
							<a href="#">
								<span>Parent</span>
								<span class="sorting-indicator"></span>
							</a>
						</th>
						<th scope="col" class="manage-column column-name sortable desc">
							<a href="">
								<span>Translations</span>
								<span class="sorting-indicator"></span>
							</a>
						</th>
						<th scope="col" id="posts" class="manage-column column-posts num sortable desc">
							<a href="#">
								<span>Rank</span>
								<span class="sorting-indicator"></span>
							</a>
						</th>	
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th scope="col" class="manage-column column-cb check-column">
							<label class="screen-reader-text" for="cb-select-all-2">Select All</label>
							<input id="cb-select-all-2" type="checkbox">
						</th>
						<th scope="col" class="manage-column column-name sortable desc" style="">
							<a href="#">
								<span>Name</span>
								<span class="sorting-indicator"></span>
							</a>
						</th>
						<th scope="col" class="manage-column column-name sortable desc" style="">
							<a href="#">
								<span>Parent</span>
								<span class="sorting-indicator"></span>
							</a>
						</th>
						<th scope="col" class="manage-column column-name sortable desc">
							<a href="">
								<span>Translations</span>
								<span class="sorting-indicator"></span>
							</a>
						</th>
						<th scope="col" class="manage-column column-posts num sortable desc" style="">
							<a href="#">
								<span>Rank</span>
								<span class="sorting-indicator"></span>
							</a>
						</th>	
					</tr>
				</tfoot>
				<tbody id="the-list" data-wp-lists="list:tag">
					<?php 
						foreach($model['pagedQnAs'] as $index=>$qna)
						{
							$trClass = "";
							if ($index % 2 == 0) {
								$trClass = "alternate";
							}
					?>
					<tr id="item-<?=$qna['ID']?>" class="<?=$trClass?>">
						<th scope="row" class="check-column">
							<label class="screen-reader-text" for="cb-select-<?=$qna['ID']?>">Select <?=$qna['Question']?></label>
							<input type="checkbox" name="itemId[]" value="<?=$qna['ID']?>" id="cb-select-<?=$qna['ID']?>"></th>
						<td class="name column-name question-holder">
							<strong>
								<span class="row-title">
									<?=stripslashes($qna['Question'])?>
								</span>
							</strong>
							<br>
							<div class="row-actions">
								<span class="inline hide-if-no-js">
									<a href="" data-item-id="<?=$qna['ID']?>" class="quickEditor" data-edit-endpoint="qna_question_edit" data-localisation-endpoint="qna_question_localisation" data-language="<?=self::getCurrentLanguage()?>">Quick&nbsp;Edit</a> |
									<a href="" data-item-id="<?=$qna['ID']?>" class="quickDelete" data-action="qna_category_delete">Delete</a>
								</span>
							</div>
						</td>
						<td class="name column-name parentName-holder">
							<span><?=$qna['ParentName']?></span>
						</td>
						<td class="name column-name parentName-holder">
							<?php $availableLanguages = explode(',',$qna['AvailableLanguages']);
							foreach($model['languages'] as $index=>$language) {
								?>
								<a href="" data-edit-endpoint="qna_question_edit" data-localisation-endpoint="qna_question_localisation" data-item-id="<?=$qna['ID']?>" data-language="<?=$language['Language']?>" class="quickEditor dashicons-before language_object <?=$language['Language']?>_lang <?php if ( in_array($language['Language'],$availableLanguages) ) {echo('dashicons-yes green');} else {echo('dashicons-no red');}?>">
									<?=$language['Language']?>
								</a>
								<?php
								if ($index < count($model['languages'])-1) {
									echo('|');
								}
							}
							?>
						</td>
						<td class="posts column-posts rank-holder">
							<span><?=$qna['Rank']?></span>
						</td>
					</tr>
					<?php } ?>

				</tbody>
			</table>
			<div class="tablenav bottom">
				<div class="alignleft actions bulkactions">
					<label for="bulk-action-selector-bottom" class="screen-reader-text">Select bulk action</label>
					<select name="action2" class="bulk-action" id="bulk-action-selector">
						<option value="-1" selected="selected">Bulk Actions</option>
						<option value="delete">Delete</option>
					</select>
					<input type="submit" name="" id="doaction2" class="button action" value="Apply">
				</div>
				<div class="tablenav-pages <?php if($model['pagination']['pageCount'] == 1) echo('one-page');?>">
					<span class="displaying-num"><?php echo($model['qnaCount']) ?> item(s)</span>
					<span class="pagination-links">
						<a class="first-page <?php if($model['pagination']['currentPage'] == 1) echo('disabled');?>" title="Go to the first page" href="<?php echo(self::generatePaginationUrl(1)); ?>">«</a>
						<a class="prev-page <?php if($model['pagination']['currentPage'] == 1 ) echo('disabled');?>" title="Go to the previous page" href="<?php if ($model['pagination']['currentPage'] > 1 ) { echo(self::generatePaginationUrl($model['pagination']['currentPage']-1)); } else { echo(self::generatePaginationUrl(1)); }; ?>">‹</a>
						<span class="paging-input">
							<label for="current-page-selector" class="screen-reader-text">Select Page</label>
							<span class="total-pages"><?php echo($model['pagination']['currentPage']); ?></span> of <span class="total-pages"><?php echo($model['pagination']['pageCount']); ?></span>
						</span>
						<a class="next-page <?php if($model['pagination']['currentPage'] == $model['pagination']['pageCount']) echo('disabled');?>" title="Go to the next page" href="<?php if($model['pagination']['currentPage'] < $model['pagination']['pageCount']) {echo(self::generatePaginationUrl($model['pagination']['currentPage']+1));}else{echo(self::generatePaginationUrl($model['pagination']['currentPage']));}?>">›</a>
						<a class="last-page <?php if($model['pagination']['currentPage'] == $model['pagination']['pageCount']) echo('disabled');?>" title="Go to the last page" href="<?php echo(self::generatePaginationUrl($model['pagination']['pageCount'])); ?>">»</a>
					</span>
				</div>
				<br class="clear">
			</div>
			<br class="clear">
			</form>	

			<div class="form-wrap">
				<p>
					<strong>Note:</strong><br>Deleting a category does not delete the answer or subcategory in that category. Instead, items that were only assigned to the deleted category will become <strong>uncategorized</strong>.</p>
			</div>
		</div>
	</div><!-- /col-right -->

	<div id="col-left">
		<div class="col-wrap">
			<div class="form-wrap">
				<h3>Add New Question And Answer</h3>
				<form id="addQnaCategory" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" class="validate" _lpchecked="1">
					<input type="hidden" name="actionType" value="addItem">
					<div class="form-field form-required">
						<label for="question">Question</label>
						<input name="question" id="question" type="text" value="" size="250" aria-required="true">
						<p>This is the question.</p>
					</div>
					<div class="form-field term-description-wrap">
						<label for="answer">Answer</label>
						<textarea name="answer" id="answer" rows="5" cols="40"></textarea>
						<p>This is the answer.</p>
					</div>
					<div class="form-field">
						<label for="parentId">Category</label>
						<select name="parentId" id="parentId" class="postform">
							<option value="0">None</option>
							<?php
							foreach($model['allCategories'] as $index=>$category)
							{ ?>
								<option class="level-<?=$index?>" <?php if (isset ($_GET['parent']) && $_GET['parent'] == $category['ID']) {echo('selected="selected"');}?> value="<?=$category['ID']?>"><?=$category['Name']?></option>
							<?php
							}
							?>
						</select>
						<p>Select the category that you want this question to list under.</p>
					</div>
					<div class="form-field form-required">
						<label for="categoryRank">Rank</label>
						<input name="categoryRank" id="categoryRank" type="number" value="0" size="2" aria-required="true">
						<p>This is the sorting order you want the question to appear.</p>
					</div>
					<div class="form-field">
						<label for="l13n">Internalisation</label>
						<select name="l13n" id="l13n" class="postform">
							<?php
							foreach($model['languages'] as $index=>$language)
							{ ?>
								<option value="<?=$language['Language']?>" <?php if($language['Language'] == self::getCurrentLanguage()) { echo 'selected';} ?>><?=$language['Language']?><?php if($language['IsDefault'] == "1") {echo('   (Default)');}?></option>
							<?php
							}
							?>
						</select>
						<p>What language this entry is in?</p>
					</div>

					<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Add New Question And Answer"></p>
					</form>
				</div>

			</div>
		</div><!-- /col-left -->
	</div><!-- /col-container -->
</div>
<form id="deleteForm" method="post" action="<?php echo(self::getPageRoute('qna_question_delete'))?>">
	<input type="hidden" value="" name="itemId" id="itemToDelete">
</form>
<!-- TEMPLATES -->
<div class="hidden templates">
	<div id="parentSelectorTemplate">
		<select name="parentSelector" style="width:100%">
			<option value="0">None</option>
			<?php
			foreach($model['allCategories'] as $index=>$category)
			{ ?>
			<option value="<?=$category['ID']?>"><?=$category['Name']?></option>
			<?php
			}?>
		</select>
	</div>
</div>
<!-- TEMPLATES END-->