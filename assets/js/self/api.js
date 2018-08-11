function getProMesAll() {
    $.ajax({
        type:"post",
        url:"http://localhost:8080/TongXinweb/project/AllPro",
        async:true,
        data:'',
        dataType:'json',
        success:function(data){
            if(data['success']) {
                tableProAll(data['data']);
            }
        },
        error:function(s,e,t){
            console.log(s,e,t);
        }
    });
}

function getProMesSel(data) {
    $.ajax({
        type:"post",
        url:"http://localhost:8080/TongXinweb/project/GetProById",
        async:true,
        data:{
            "projectId":"0b5c5b47-0927-48ec-a336-9b925881ec54",
        },
        success:function(data){
            console.log(data);
//          return dara;
        },
        error:function(s,e,t){
            console.log(s,e,t);
        }
    });
}

function getFomMesAll() {
    
    $.ajax({
        type:"post",
        url:"http://localhost:8080/TongXinweb/form/Allform",
        async:true,
        data:'',
        dataType:'json',
        success:function(data){
            
        },
        error:function(s,e,t){
            console.log(s,e,t);
        }
    });
}

function getFomMesSel_ProId() {
    var proId = sessionStorage.getItem('projectId');
    $.ajax({
        type:"post",
        url:"http://localhost:8080/TongXinweb/form/getFormByPid",
        async:true,
        data:{
            "projectId":proId,
        },
        dataType:'json',
        success:function(data){
            if(data['success']) {
                tabMesShow_Pro(data['data']);
            }
        },
        error:function(s,e,t){
            console.log(s,e,t);
        }
    });
}

function getFomMesSel_FomId() {
    $.ajax({
        type:"post",
        url:"http://localhost:8080/TongXinweb/form/getFormByFid",
        async:true,
        data:{
            "formId":"36dde2bb-d8bc-4cf2-aa7e-3c8fe2a8bb0b",
        },
        success:function(data){
            console.log(data);
//          return dara;
        },
        error:function(s,e,t){
            console.log(s,e,t);
        }
    });
}