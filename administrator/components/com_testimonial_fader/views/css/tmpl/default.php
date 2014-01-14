<?php 
defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');

$template_path = JPATH_SITE.DS.'components'.DS.'com_testimonial_fader'.DS.'css'.DS.'style.css';

if ($fp = @fopen($template_path, 'r')) {
	$csscontent = @fread($fp, @filesize($template_path));
	$csscontent = htmlspecialchars($csscontent);
} else {
	echo 'Error reading template file: '.$template_path;
}
?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
        <fieldset class="adminform">
            <legend><?php echo JText::_( 'Details' ); ?></legend>
			<p><?php echo JText::_( 'Do not edit this if you do not understand CSS' ); ?></p>
            <table class="adminform">
			<tr>
				<th>
				<?php echo $template_path; ?>
                <span class="componentheading">
				<?php
				echo is_writable($template_path) ? ' - <strong style="color:green;">'.JText::_( 'CSS file is writable' ).'</strong>' :'<strong style="color:red;">'.JText::_( 'CSS file is not writable' ).'</strong>';?>
				</span>
                </th>
			</tr>
			<tr>
				<td>
					<textarea style="width: 100%; height: 600px" cols="80" rows="25" name="csscontent" class="inputbox"><?php echo $csscontent; ?></textarea>
				</td>
			</tr>
		</table>
    <input type="hidden" name="option" value="com_testimonial_fader" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="controller" value="css" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
