/*
 * 列表动作
 */
//提交/归集/驳回/逾期/撤回归集/重新提交
function ChangeSta(uri,ActTy){
//  if (ActTy == 'draf') {
    	var Mes = $('#formId').val()
//  } else{
//  	var Mes = GetCheckMes();
//  }
    var TabName_Data = 'table_mes'
    if(Mes) {
        if(ActTy == 'draf'){
            TabName_Data = 'table_mes_cache'
        }
        var uriCheckA = uri.split('StaChange');
        var uriCheck = uriCheckA[0] + 'FromTypeCheck'
        $.ajax({
        	type:"post",
        	url:uriCheck,
        	async:true,
        	dataType:'json',
        	data:{
        	    formId:Mes,
        	    TabName:TabName_Data
        	},
        	success:function(data){
        	    if(data.TypSta == 'allow'){
//      	        console.log(uri)
        	        //change status
                    $.ajax({
                        type:"post",
                        url:uri,
                        async:true,
                        data:{
                            formId:Mes,
                        },
                        dataType:'json',
                        success:function(data){
                            if(data['status'] == 'success'){
                                alert(data['Name']+'成功')
                                if(!(ActTy == 'draf' || ActTy == 'pack')){
                                    tabMesAll.ajax.reload();
                                }
                            }
                            else{
                                alert('出现错误，请及时联系管理员[FSC004]')
                            }
                        },
                        error:function(s,t,e){
                            alert('出现错误，请及时联系管理员[FSC003]')
                        }
                    })
        	    }
        	    else{
        	        alert('请检查表单的类型与截止日期是否选择')
        	    }
        	},
        	error:function(s,e,t){
        	    alert('出现错误，请及时联系管理员[FSC001]')
        	}
        });
        
    }else{
        alert('请选择后再进行操作');
    }
}
//打印
function PrintOut(printAre){
    var headstr="<html><head><title></title></head><body>";
    var footstr="</body>";
    var newstr=document.all.item(printpage).innerHTML;
    var oldstr=document.body.innerHTML;
    document.body.innerHTML=headstr+newstr+footstr;
    window.print(); 
    document.body.innerHTML=oldstr;
    return false;
}
/*
 * 公用函数
 */
//获取信息表格中选中的行
function GetCheckMes() {
    var tab = document.getElementById("dynamic-table");
    var CheckSta ;
    var StrId = '';
    for (var i=1;i<tab.rows.length;i++) {
        try{
        	CheckSta = tab.rows[i].cells[0].getElementsByTagName('input')[0];
            if(CheckSta.checked == 1) {
                StrId+=tab.rows[i].cells[1].getElementsByTagName('a')[0].innerHTML+',';
            }
        }catch(e){
        	alert('没有相关数据，请选择数据后操作');
        }
    }
    StrId = StrId.substr(0,StrId.length-1);
    return StrId;
}
