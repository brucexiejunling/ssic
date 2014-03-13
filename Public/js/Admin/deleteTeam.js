(function() {

    var $deleteBtn = $('button.delete')

    $deleteBtn.on('click', function(event) {
        var $tr = $(this).closest('tr');
        var teamId = $tr.find('input').val();
        console.log(teamId);
        var teamName = $tr.find('td').eq(0).html();
        console.log(teamName);
        if (!confirm("您确定要删除"+" "+teamName+" "+"吗?")) {
            return;
        }
        $.ajax({
            url: URL+'/deleteTeam',
            type: 'POST',
            data: {
                teamId: teamId
            },
            success: function(data) {
                console.log(data)
                if (data.msg === 'ok') {
                    $tr.remove();
                    alert('删除成功!')
                } else {
                    alert('删除失败！')
                }
            },
            error: function(e) {
                console.error(e)
                alert('修改失败！服务器连接错误！')
            }
        })
    })

})()