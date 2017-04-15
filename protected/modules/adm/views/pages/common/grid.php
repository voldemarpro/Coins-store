<?php
/**
 * Общий шаблон для вывода списка записей из справочников в табличном виде
 */
$totalWidth = 0;
$labels = array();
$widths = array();
//$maxWidths = array();

// параметры для контейнера с действиями
$actionsAttr = array(
	'delete'=>array('Delete', 'title="Delete" class="del"'),
	'in-archive'=>array('In archive', 'title="In archive" class="del"')
);
$actionsListWidth = sizeof($grid['actions'])*20;

// полное число столбцов
$cols = sizeof($grid['attributes']);

$actions = '<span class="table-actions">';
foreach ($grid['actions'] as $action)
	$actions .= "<a href=\"/{$this->module->name}/{$this->id}/{$action}/{id}\" {$actionsAttr[$action][1]}>{$actionsAttr[$action][0]}</a>";
$actions .=	'</span>';

// связи для опредления ширины связанных столбцов
$relations = $dataProvider->model->relations();
?> 
			<h1><?php echo $this->pageTitle ?></h1>
			<div class="top-nav"><?php
				
				// Постраничная навигация
				if ($dataProvider->data && $dataProvider->pagination && $dataProvider->pagination->pageCount > 1)
				{
					echo '
					<ul class="pagination">';
					$this->renderFile(
						dirname($this->viewPath).'/common/paging.php',
						array('pagination'=>$dataProvider->pagination)
					);
					echo '
					</ul>';
				}
				
				if (method_exists(get_class($this), 'actionAdd')) echo '
				<div class="actions">
					<a href="/', $this->module->name, '/', $this->id, '/add" class="button">Add Item</a>
				</div>';
			
			?> 
			</div><?php
			
			if ($dataProvider->data) {
			?> 
			<table class="<?php echo basename($this->id) ?>">
				<thead>
					<tr><?php
					
					// определение ширины каждого столбца
					foreach ($grid['attributes'] as $i=>$col) {
						$widths[$i] = 0;
						foreach ($col as $key=>$attr) {
							if (is_numeric($key)) {
								$labels[$i][] = $dataProvider->model->getAttributeLabel($attr);									
								$width = $dataProvider->model->tableSchema->columns[$attr]->size;		
							} elseif (isset($grid['lists'][$key])) {
								$labels[$i][] = $dataProvider->model->getAttributeLabel($key);									
								$width = $dataProvider->model->tableSchema->columns[$attr]->size;		
							} else {
								$labels[$i][] = $dataProvider->model->getAttributeLabel($key);
								$model = new $relations[$key][1];
								$width = $model->tableSchema->columns[$attr]->size;
							}
							$widths[$i] += ($width > strlen(current($labels[$i]))) ? $width : strlen(current($labels[$i]));	
						}
						//if (!$widths[$i]) $widths[$i] = $maxWidths[$dataProvider->model->tableSchema->columns[$attr]->dbType];
						if (($i + 1) == $cols) $widths[$i] += $actionsListWidth;
						$totalWidth += $widths[$i];	
					}

					foreach ($grid['attributes'] as $i=>$col)
						echo '
						<th width="', floor($widths[$i]/$totalWidth*100), '%">', implode(' ', $labels[$i]), '</th>';

					?>
					</tr>
				</thead>
				<tbody>
			
				<?php
				// построение таблицы
				foreach ($dataProvider->data as $rec) {
					echo '
						<tr>';

					foreach ($grid['attributes'] as $i=>$col) {
						$text = array();
						echo '
							<td>';
							
						foreach ($col as $key=>$attr) {
							if (is_numeric($key))
								$text[] = $rec->$attr;
							elseif (isset($grid['lists'][$key]))
								$text[] = (isset($grid['lists'][$key][$rec->$key])) ? $grid['lists'][$key][$rec->$key] : '&nbsp;';
							elseif (is_scalar($rec->$key) || isset($rec->$key->$attr))
								$text[] = is_scalar($rec->$key) ? $rec->$key : $rec->$key->$attr;
						}
						
						$text = implode($text, ' ');

						if ($i == $grid['grand_attr'] && $i < ($cols - 1))
							echo '
								<div>
									<a href="/', $this->module->name, '/', $this->id, '/edit/', $rec->id.'">', $text, '</a>
								</div>';
						elseif ($i == $grid['grand_attr'] && $i == ($cols - 1))		
							echo '
								<div>
									<a href="/', $this->module->name, '/', $this->id, '/edit/', $rec->id.'">', $text, '</a>',
									str_replace('{id}', $rec->id, $actions), '
								</div>';
						elseif ($i && $i == ($cols - 1))	
							echo '
								<div>',
									$text, str_replace('{id}', $rec->id, $actions), '
								</div>';										
						else
							echo $text;
				
						echo '
							</td>';
					}
					
					echo '
						</tr>';						
				}
					
				?> 
				</tbody>
			</table><?php
			
			} else echo '
			<p>No items to display</p>';
			
			?> 
			<div class="cover"></div>
			<div class="confirm">
				<p></p>
				<p class="control">
					<a class="button" href="">Yes</a>&nbsp;&nbsp;<a class="button close" href="">No</a>
				</p>
			</div>