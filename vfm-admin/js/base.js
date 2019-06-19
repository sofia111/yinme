$(function () {

      //公告获取
      $(function () {
          $.ajax({
            url:'vfm-admin/get_announce.php',
            type:'POST',
            success:function (res) {
              $('.announce_content').html(res);
              
              setTimeout(function () {
                  $('.QQlink').addClass('QQlink_f');
              },50);
              setTimeout(function () {
                  $('.QQlink').removeClass('QQlink_f');
              },10000);
            }
          })
        })
      
      //列表
      //var news = [{
      //      "title":"放假余额",
      //      "URL":"#"
      //}, {
      //      "title":"有种天气叫长沙",
      //      "URL":"#"
      //}, {
      //      "title":"电费新通知",
      //      "URL":"#"
      //}, {
      //      "title":"假期开放的餐厅",
      //      "URL":"#"
      //}, {
      //      "title":"最新校历",
      //      "URL":"#"
      //}, {
      //      "title":"校园地图",
      //      "URL":""
      //}];
      var activities = [{
            "title":"服装T台秀",
            "URL":"#"
      }, {
            "title":"艺术毕设展",
            "URL":"#"
      }, {
            "title":"校运会",
            "URL":"#"
      }, {
            "title":"民族文化节",
            "URL":"#"
      }, {
            "title":"毕业典礼",
            "URL":"#"
      }, {
            "title":"校园婚礼",
            "URL":"#"
      }, {
            "title":"沸焰音乐节",
            "URL":"#"
      }, {
            "title":"包饺子大赛",
            "URL":"#"
      }, {
            "title":"绝地求生",
            "URL":"#"
      }];
      var foods = [{
            "title":"三楼美食城",
            "URL":"#"
      }, {
            "title":"懒人美食",
            "URL":"#"
      }, {
            "title":"‘我们家’的餐厅",
            "URL":"#"
      }, {
            "title":"西门小街",
            "URL":"#"
      }, {
            "title":"路边摊",
            "URL":"#"
      }, {
            "title":"南门思必客",
            "URL":"#"
      }, {
            "title":"放心羊肉",
            "URL":"#"
      }, {
            "title":"锅巴饭",
            "URL":"#"
      }, {
            "title":"书亦烧仙草",
            "URL":"#"
      }];
      var surroundings = [{
            "title":"快递店分布",
            "URL":"#"
      }, {
            "title":"地下水果摊",
            "URL":"#"
      }, {
            "title":"逛街必往",
            "URL":"#"
      }, {
            "title":"周边旅馆",
            "URL":"#"
      }, {
            "title":"台球馆",
            "URL":"#"
      }, {
            "title":"眼镜店",
            "URL":"#"
      }, {
            "title":"电影院",
            "URL":"#"
      }, {
            "title":"超市",
            "URL":"#"
      }];

      //屏幕尺寸适应
      if(news){
	if($(window).width() < 500){
            function ADD_S(arr,str) {
                  for (var i = 0; i < arr.length; i++) {
                        str += '<td class="link-list"><a href="'+arr[i].URL+'">'+arr[i].title+'</a></td>';
                  }
                  return str;
            }
            var newsStr = '<tr><tr class="row"><td class="col-md-2">新闻快讯<small style="color: green;">掌握新动态</small></td>';
            newsStr = ADD_S(news,newsStr);
            var activitiesStr = '</tr><tr class="row"><td class="col-md-2">活动<small style="color: orange;">不枉此生走一回</small></td>';
            activitiesStr = ADD_S(activities,activitiesStr);
            var foodsStr = '</tr><tr class="row"><td class="col-md-2">美食<small style="color: cyan;">生活如此多娇</small></td>';
            foodsStr = ADD_S(foods,foodsStr);
            var surroundingsStr = '</tr><tr class="row"><td class="col-md-2">周边<small style="color: red;">汝将上下而求索</small></td>';
            surroundingsStr = ADD_S(surroundings,surroundingsStr);
            var allStr = newsStr + activitiesStr + foodsStr + surroundingsStr + '</tr>';
            $('.table').html(allStr);
	} else{
            function ADD_L(arr,str) {
                  for (var i = 0; i < arr.length; i++) {
                        str += '<td><a href="'+arr[i].URL+'">'+arr[i].title+'</a></td>';
                  }
                  return str;
            }
            var newsStr = '<tr><td>新闻快讯<small style="color: green;">掌握新动态</small></td>';
            newsStr = ADD_L(news,newsStr);
            var activitiesStr = '</tr><tr><td>活动<small style="color: orange;">不枉此生走一回</small></td>';
            activitiesStr = ADD_L(activities,activitiesStr);
            var foodsStr = '</tr><tr><td>美食<small style="color: cyan;">生活如此多娇</small></td>';
            foodsStr = ADD_L(foods,foodsStr);
            var surroundingsStr = '</tr><tr><td>周边<small style="color: red;">汝将上下而求索</small></td>';
            surroundingsStr = ADD_L(surroundings,surroundingsStr);
            var allStr = newsStr + activitiesStr + foodsStr + surroundingsStr + '</tr>';
            $('.table').html(allStr);
      }
      };
      //map-tab
      $('.title-item').on("click",function() {
            $('.title-item').removeClass('titleactive');
            $('.title-item').eq($(this).index()).addClass('titleactive');
            $('.mapitem').hide();
            $('.mapitem').eq($(this).index()).show();
      })
      //suggestion
      $('.btn-primary').on("click",function() {
            var suggestion = $('.suggestion').val();
            $.ajax({
                  url:"vfm-admin/suggestion.php",
                  data:{
                        "suggestion":suggestion
                  },
                  type:"POST",
                  success: function () {
                        alert("感谢您的反馈！");
                        $('.suggestion').val("");
                  }
            })
      })
	//ad弹窗
	// var SCREENWIDTH = screen.width - 220;
	// var SCREENHEIGHT = screen.height + 150;
	// var ad = $('.ad')[0];
	// if(SCREENWIDTH <= 300) $(ad).hide();
	// var xspeed = 1;
	// var yspeed = .6;
	// var ad_x = 0;
	// var ad_y = 0;
	// var Move = setInterval(function () {
	// 	if(ad_x >= SCREENWIDTH || ad_x < 0) xspeed = -xspeed;
	// 	if(ad_y >= SCREENHEIGHT || ad_y < 0) yspeed = -yspeed;
	// 	ad_x += xspeed;
	// 	ad_y += yspeed;
	// 	ad.style.left = ad_x + 'px';
	// 	ad.style.top = ad_y + 'px';
	// },10);
})
