$(function(){
    /*
     * 左边树/菜单栏动作
     */
    var tagName = sessionStorage.getItem("tagName");
//  console.log(tagName);
    if(!tagName){
        var tagName = 'affairShow_Proj';
    }
    $('#'+tagName).parent('.TagSon').addClass('active');
    $('#'+tagName).parents('.TagFather').addClass('open');
    
    //  点击菜单后，JS写入缓存
    $('.TagSet').click(function(){
        $pageSta = $(this).attr("id");
        if($pageSta == 'SignOut') {
            $pageSta = 'affairShow_Proj';
            sessionStorage.setItem('projectId','');
        }
        sessionStorage.setItem("tagName", $pageSta); 
    });
    
    /*
     * control for link pro&action
     */
    var ProSelect = sessionStorage.getItem("projectId");
    var ProSelectName = sessionStorage.getItem("projectName");
    if(ProSelect===null||ProSelect.length==0) {
        $('.Require').addClass('NoAction');
//      for (var i=0;i<3;i++) {
//      	var text = $('.Require').find('.menu-text').eq(i).text();
//          $('.Require').find('.menu-text').eq(i).text('请先选定工程');
//      }
    }else{
        //工程名称显示
        $('#proName').text('【选中工程：'+ProSelectName+'】');
    }
    
    /*
     * draf & Pack => css
     */
    if (tagName == 'formShow_Draf' || tagName == 'formShow_Pack') {
        $('#tabList').removeClass('col-xs-5');
        $('#tabList').addClass('col-xs-7');
        $('#tabDetailMes').removeClass('col-xs-7')
        $('#tabDetailMes').addClass('col-xs-12')
    }
    
    /*
     * model
     */
    //override dialog's title function to allow for HTML titles
    $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
        _title: function(title) {
            var $title = this.options.title || '&nbsp;'
            if( ("title_html" in this.options) && this.options.title_html == true )
                title.html($title);
            else title.text($title);
        }
    }));
    /*
     * show and select
     */
    $( "#id-btn-dialog" ).on('click', function(e) {
        e.preventDefault();
    
        var dialog = $( "#dialog-message" ).removeClass('hide').dialog({
            modal: true,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='ace-icon fa fa-check'></i>工作流设置</h4></div>",
            title_html: true,
            buttons: [ 
                {
                    text: "取消",
                    "class" : "btn btn-minier",
                    click: function() {
                        $( this ).dialog( "close" ); 
                    } 
                },
                {
                    text: "确定",
                    "class" : "btn btn-primary btn-minier",
                    click: function() {
                        
//                      $('#CirMes tr').eq(1).find('td').eq(2).find('select').val();
                        $( this ).dialog( "close" );
                    } 
                }
            ],
            width: "1200px",
        });
    });
    /*
     * show and save new
     */
    $( "#id-btn-dialog-new" ).on('click', function(e) {
        e.preventDefault();
    
        var dialog = $( "#dialog-message-new" ).removeClass('hide').dialog({
            modal: true,
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'><i class='ace-icon fa fa-check'></i>工作流设置</h4></div>",
            title_html: true,
            buttons: [ 
                {
                    text: "取消",
                    "class" : "btn btn-minier",
                    click: function() {
                        $( this ).dialog( "close" ); 
                    } 
                },
                {
                    text: "确定",
                    "class" : "btn btn-primary btn-minier",
                    click: function() {
                        //get the num of tr
                        var RNum = $('#TurnNum-new').val();
                        var uri = $('#uriOwn-new').val();
                        var Data = [];
                        for (var i=0;i<RNum;i++) {
                        	Data.push($('#CirMes-new tr').eq(i+1).find('td').eq(1).find('select').val());
                        }
                        var TypeId = $('#TypeId-new').attr('value');
                        //send mes
                        $.ajax({
                        	type:"post",
                        	url:uri,
                        	async:true,
//                      	dataType:'json',
                        	data:{
                        	    data:Data,
                        	    TypeId:TypeId
                        	},
                        	success:function(data){
                                //clear old mes
                        	    $('.steps').html('');
                        	    //creat new mes
                                if(Data.length>0){
                                    for (var i=0;i<Data.length;i++) {
                                        $('.steps').append("<li class='active' data-step='"+(i+1)+"'><span class='step'>"+(i+1)+"</span><span class='title'>"+Data[i]+"</span></li>");
                                    }
                                }
                        	},
                        	error:function(s,e,t){
                        	    console.log(s,e,t);
                        	}
                        });
                        $( this ).dialog( "close" );
                    } 
                }
            ],
            width: "1200px",
        });
    });

});
