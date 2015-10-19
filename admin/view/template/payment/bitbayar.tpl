<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-pp-std-uk" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if (isset($error['error_warning'])) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error['error_warning']; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    
	<?php if ($error_idr) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_idr; ?><br/></div>
	<?php } ?>


    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-pp-std-uk" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-status" data-toggle="tab"><?php echo $tab_order_status; ?></a></li>
            <li><a href="#tab-help" data-toggle="tab"><?php echo $tab_help; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">

            <div class="form-group required">
                <label class="col-sm-2 control-label" for="entry_api"><span data-toggle="tooltip" title="<?php echo $help_api; ?>"><?php echo $entry_api; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="bitbayar_api" value="<?php echo $bitbayar_api; ?>" placeholder="<?php echo $entry_api; ?>" id="entry_api" class="form-control"/>
                  <?php if ($error_api) { ?>
                  <div class="text-danger"><?php echo $error_api; ?></div>
                  <?php } ?>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="entry-email"><span data-toggle="tooltip" title="<?php echo $help_email; ?>"><?php echo $entry_email; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="bitbayar_email" value="<?php echo $bitbayar_email; ?>" placeholder="<?php echo $entry_email; ?>" id="entry-email" class="form-control"/>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_buttons; ?></label>
                <div class="col-sm-10">
                <input type="radio" name="bitbayar_buttons" value="large" <?php if($bitbayar_buttons == 'large'){?>checked="checked"<?php } ?> /> <img src="view/image/payment/bitbayar-pay-large.png" alt="i01" style="padding-right: 10px;">
                <input type="radio" name="bitbayar_buttons" value="medium" <?php if($bitbayar_buttons == 'medium'){?>checked="checked"<?php } ?> /> <img src="view/image/payment/bitbayar-pay-medium.png" alt="i02" style="padding-right: 10px;">
                <input type="radio" name="bitbayar_buttons" value="small" <?php if($bitbayar_buttons == 'small'){?>checked="checked"<?php } ?> /> <img src="view/image/payment/bitbayar-pay-small.png" alt="i03" style="padding-right: 10px;">
                <input type="radio" name="bitbayar_buttons" value="text" <?php if($bitbayar_buttons == 'text'){?>checked="checked"<?php } ?> /> <?php echo $entry_buttons_text; ?>
                </div>
              </div>
			<!--
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><*?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-10">
                  <select name="bitbayar_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><*?php echo $text_all_zones; ?></option>
                    <*?php foreach ($geo_zones as $geo_zone) { ?>
                    <*?php if ($geo_zone['geo_zone_id'] == $bitbayar_geo_zone_id) { ?>
                    <option value="<*?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><*?php echo $geo_zone['name']; ?></option>
                    <*?php } else { ?>
                    <option value="<*?php echo $geo_zone['geo_zone_id']; ?>"><*?php echo $geo_zone['name']; ?></option>
                    <*?php } ?>
                    <*?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><*?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="bitbayar_sort_order" value="<*?php echo $bitbayar_sort_order; ?>" placeholder="<*?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control"/>
                </div>
              </div>
			-->
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="bitbayar_status" id="input-status" class="form-control">
                    <?php if ($bitbayar_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
  
              <div class="form-group">
                <label class="col-sm-2 control-label" for="entry-email"><?php echo $entry_memo; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="bitbayar_memo" value="<?php echo $bitbayar_memo; ?>" placeholder="ie: Invoice #123 Jose Alejandro" class="form-control"/>
                  <span class="info">Options input to memo : </span><br/>
                  <span class="info">[invoiceID] = Get invoice number</span>
                </div>
              </div>
              
            </div>
            
            <!-- Tab Status--> 
            <div class="tab-pane" id="tab-status">
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_confirmed_status; ?>"><?php echo $entry_confirmed_status; ?></span></label>
                <div class="col-sm-10">
                  <select name="bitbayar_confirmed_status_id" class="form-control">
                    <?php if($bitbayar_confirmed_status_id == NULL) $bitbayar_confirmed_status_id = 15; ?>
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $bitbayar_confirmed_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_pending_status; ?>"><?php echo $entry_pending_status; ?></span></label>
                <div class="col-sm-10">
                  <select name="bitbayar_pending_status_id" class="form-control">
                  <?php if($bitbayar_pending_status_id == NULL) $bitbayar_pending_status_id = 1; ?>
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $bitbayar_pending_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_timeout_status; ?>"><?php echo $entry_timeout_status; ?></span></label>
                <div class="col-sm-10">
                  <select name="bitbayar_timeout_status_id" class="form-control">
                  <?php if($bitbayar_timeout_status_id == NULL) $bitbayar_timeout_status_id = 14; ?>
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $bitbayar_timeout_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_received_status; ?>"><?php echo $entry_received_status; ?></span></label>
                <div class="col-sm-10">
                  <select name="bitbayar_received_status_id" class="form-control">
                  <?php if($bitbayar_received_status_id == NULL) $bitbayar_received_status_id = 1; ?>
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $bitbayar_received_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_invalid_status; ?>"><?php echo $entry_invalid_status; ?></span></label>
                <div class="col-sm-10">
                  <select name="bitbayar_invalid_status_id" class="form-control">
                  <?php if($bitbayar_invalid_status_id == NULL) $bitbayar_invalid_status_id = 16; ?>
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $bitbayar_invalid_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_refunded_status; ?>"><?php echo $entry_refunded_status; ?></span></label>
                <div class="col-sm-10">
                  <select name="bitbayar_refunded_status_id" class="form-control">
                   <?php if($bitbayar_refunded_status_id == NULL) $bitbayar_refunded_status_id = 11; ?>
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $bitbayar_refunded_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_pat_status; ?>"><?php echo $entry_pat_status; ?></span></label>
                <div class="col-sm-10">
                  <select name="bitbayar_pat_status_id" class="form-control">
                   <?php if($bitbayar_pat_status_id == NULL) $bitbayar_pat_status_id = 16; ?>
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $bitbayar_pat_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_insufficient_amount_status; ?>"><?php echo $entry_insufficient_amount_status; ?></span></label>
                <div class="col-sm-10">
                  <select name="bitbayar_insufficient_amount_status_id" class="form-control">
                  <?php if($bitbayar_insufficient_amount_status_id == NULL) $bitbayar_insufficient_amount_status_id = 16; ?>
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $bitbayar_insufficient_amount_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            
            <!-- Tab Help-->
            <div class="tab-pane" id="tab-help">
				<div class="form-group">
					<ol>
						<li style="padding-bottom: 20px;"><p><b>IDR Currency Require!</b></p>
							<p>If your default currency is not <b>IDR Rupiah</b>, please add first under <i>System > Localisation > Currencies</i></p>
							<img src="view/image/payment/bb-opencart-currencies.png" alt="IDR Currency">
						</li>
						<li><p><b>Update Default Currency on Store Setting</b></p>
							<p>Change default currency unde <i>System > Settings > Edit Your Store > Local Tab > Currency</i></p>
							<img src="view/image/payment/bb-opencart-default-currency.png" alt="Default Currency">
						</li>
					</ol>
					
				</div>
            </div>
            
            
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>