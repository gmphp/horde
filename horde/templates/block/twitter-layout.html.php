<?php
/**
 * Twitter client initial layout
 * Uses:
 *   ->instance
 *   ->defaultText
 *   ->loadingImg
 *   ->latestStatus
 *   ->latestDate
 *   ->bodyHeight
 */
?>
<div style="padding: 8px 8px 0 8px">
 <div class="fbgreybox">
   <textarea rows="2" style="width:98%;margin-top:4px;margin-bottom:4px;" type="text" id="<?php echo $this->instance ?>_newStatus" name="<?php echo $this->instance ?>_newStatus"><?php echo $this->defaultText ?></textarea> <a class="button" onclick="Horde['twitter<?php echo $this->instance ?>'].updateStatus($F('<?php echo $this->instance ?>_newStatus'));" href="#"><?php echo _("Tweet") ?></a>
   <span id="<?php echo $this->instance ?>_counter" style="color:rgb(204, 204, 204); margin-left:6px;">140</span>
   <span id="<?php echo $this->instance ?>_inReplyTo"></span>
   <?php echo $this->loadingImg ?>
   <div id="currentStatus" style="margin:10px;"><strong><?php echo _("Latest")?></strong> <?php echo $this->latestStatus ?> - <span class="fbstreaminfo"><?php echo $this->latestDate ?></span></div>
 </div>
 <br />
 <div class="tabset">
  <ul>
   <li id="<?php echo $this->instance ?>_contenttab" class="activeTab"><a href="#" onclick="Horde['twitter<?php echo $this->instance ?>'].showStream();return false;"><?php echo _("Stream")?></a></li>
   <li id="<?php echo $this->instance ?>_mentiontab"><a href="#" onclick="Horde['twitter<?php echo $this->instance ?>'].showMentions();return false;"><?php echo _("Mentions") ?></a></li>
  </ul>
 </div>
 <div class="clear">&nbsp;</div>
 <div class="hordeSmPreview" id="<?php echo $this->instance?>_preview"></div>
 <div style="height:<?php echo $this->bodyHeight ?>px; overflow-y:auto; overflow-x:hidden" id="<?php echo $this->instance ?>_twitter_body">
   <div id="<?php echo $this->instance ?>_stream"></div>
   <div id="<?php echo $this->instance ?>_mentions"></div>
 </div>
 <br />
 <div class="hordeSmGetmore"><input type="button" class="button" id="<?php echo $this->instance ?>_getmore" value="<?php echo _("Get More") ?>"></div>
</div>