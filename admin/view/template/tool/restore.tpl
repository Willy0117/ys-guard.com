<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/backup.png');"><?php echo $heading_title; ?></h1>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data"  id="form">
      <table class="form">
        <tr>
          <td colspan="2"><?php echo $entry_description; ?></td>
        </tr>
        <tr>
          <td width="25%"><?php echo $entry_restore; ?></td>
          <td>

※ 復元を実行する日付を指定して下さい<br />
<select name="year">
<?php foreach(range(2013,date('Y')) as $year) :?>
<option value="<?php echo $year; ?>" <?php if (isset($_POST["year"]) and  $year==$_POST["year"]): ?>selected<?php endif; ?>><?php echo $year; ?></option>
<?php endforeach; ?>
</select>
年
<select name="month">
<?php foreach(range(1,12) as $month) :?>
<option value="<?php echo $month; ?>" <?php if (isset($_POST["month"]) and  $month==$_POST["month"]): ?>selected<?php endif; ?> ><?php echo $month; ?></option>
<?php endforeach; ?>
</select>
月
<select name="date">
<?php foreach(range(1,31) as $day) :?>
<option value="<?php echo $day; ?>" <?php if (isset($_POST["date"]) and  $day==$_POST["date"]): ?>selected<?php endif; ?>><?php echo $day; ?></option>
<?php endforeach; ?>
</select>
日
<input type="submit" name="execute" value="リストア">
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>
