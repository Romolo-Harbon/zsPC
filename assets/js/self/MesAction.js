/*
 * 列表动作
 */
//查看
function CheckOut(MType){
    
}
//提交/归集/驳回/逾期/撤回归集/重新提交
function ChangeSta(MType,CT){
    var Mes = GetCheckMes();
    var hostLoad = window.location.protocol+'//'+window.location.host;
    hostLoad += '/zsPC/index.php/MesContro/change_sta';
    if(Mes) {
        $.ajax({
        	type:"post",
        	url:hostLoad,
        	async:true,
        	data:{
        	    MesId:Mes,
        	    MesType:MType,
        	    CT:CT
        	},
        	success:function(data){
        	    alert(data+'成功');
        	    location.reload();
        	},
        	error:function(s,t,e){
        	    alert('请选择后再进行操作');
        	}
        });
    }
}
//打印
function PrintOut(MType){
    
}
//重命名
function ReSet(MType){
    
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
