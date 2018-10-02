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
 * reset
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
 * new in beginning
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
//                          dataType:'json',
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