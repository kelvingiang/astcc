jQuery(document).ready (function(){
   
	// tìm tất cả các <li> trong thẻ có id la tapfirst
	// mọi <li> đểu bị duyệt qua, thông qua each sẽ tra về tham số index
	// thông qua "index" sẽ tìm ra các the nội dung "aside"
	jQuery("#tap-title li").each(function(index){
		// khi mouseover trong thẻ li
	  jQuery(this).click(function(){
		  // tạo biến đế chưa this 
		  // khi vào trong funciton khác this không còn giá trị
		var liNode =jQuery(this);
		// cho thời gian thật thi chậm lại 300 giây
		timeoutid = setTimeout(function(){
			// bỏ đi class contentiin có nghỉ là ẩn đi nội dung
		  jQuery("div.content-current").removeClass("content-current");
		      // bỏ đi class tapiin hiện đa được chọn.
		  jQuery("#tap-title li.current").removeClass("current");
		  // add lại class được chọn cho các thẻ được chọn eq(số thứ tự).
   		  jQuery("div.tap-content:eq("+ index + ")").addClass('content-current');
		  liNode.addClass("current");
		  //$("aside").eq(index).addClass("contentin");
		 },300);
	   });
    });
    
        jQuery('.MyDate').datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true
    });
});


