// Get GMT from client
function getTimezoneOffset() {
        function z(n) {
            return (n < 10 ? '0' : '') + n
        }
        var offset = new Date().getTimezoneOffset();
        var sign = offset < 0 ? '+' : '-';
        offset = Math.abs(offset);
      return sign + z(offset / 60 | 0) +":"+ z(offset % 60);
    }

// Animated sliding fadin and out
var slideFunction = function(e) {
        setTimeout(function() {
            $('.single-warp[data-notification="' + (e + 1) + '"]').animate({
                opacity: 1,
                left: "50%"
            }, {
                duration: 1500
            }).addClass("is-active")
        }, 1250)
    };

    setInterval(function() {
        $(".single-warp.is-active").animate({
            opacity: 0,
            left: "+=10%"
        }, {
            duration: 1500,
            start: function() {
                var e = Number($(this).attr("data-notification")),
                    t = $(".single-warp").length;
                slideFunction(t === e ? 0 : e)
            },
            complete: function() {
                $(this).removeClass("is-active"); $(this).css("left", "40%")
            }
        })
    }, 7000);
// End  Animated sliding fadin and out
