function edToolbar(id) {
  document.write('<div class="ed_toolbar" id="ed_toolbar' + id + '">');
  for (i = 0; i < edButtons.length; i++) {
    edShowButton(edButtons[i], i, id);
  }
  document.write('<a href="javascript:edCloseAllTags(' + id + ');"><img src="/sites/all/modules/quicktags/ed_close.png" id="ed_close" class="ed_button" title="Close all open tags" alt="Close Tags"/></a>');
  document.write('</div>');
}
edButtons[edButtons.length] = new edButton('0','','','','','-1','','');
edButtons[edButtons.length] = new edButton('ed_italic','italic','<em>','</em>','i','-1','','/sites/all/modules/thatotherpaper_quicktags/images/ed_italic.png');
edButtons[edButtons.length] = new edButton('ed_bold','bold','<strong>','</strong>','b','-1','','/sites/all/modules/thatotherpaper_quicktags/images/ed_bold.png');
edButtons[edButtons.length] = new edButton('ed_link','link','<a href="http://">','</a>','l','-1','','/sites/all/modules/thatotherpaper_quicktags/images/ed_link.png');
edButtons[edButtons.length] = new edButton('ed_block','blockquote','<blockquote>','</blockquote>','q','-1','','/sites/all/modules/thatotherpaper_quicktags/images/ed_block.png');
edButtons[edButtons.length] = new edButton('ed_code','code','<code>','</code>','c','-1','','/sites/all/modules/thatotherpaper_quicktags/images/ed_code.png');
edButtons[edButtons.length] = new edButton('ed_break','teaser break','<!--break-->','','t','-1','','/sites/all/modules/thatotherpaper_quicktags/images/ed_break.png');
