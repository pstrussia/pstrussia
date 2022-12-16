$(function(){
  const tabs = $(".tabs")
  let observer = new MutationObserver(mutationRecords => {
    getTabs()
  })
  const tabsContent = $('.tabs__content li')
  for (let element of tabsContent) {
    if (!element) {
      return
    }
    observer.observe(element, {
      attributes: true,
      childList: true,
      subtree: true
    });
  }
  if (tabs.length) {
    getTabs()

    let timer = null;
    let isClickHandled = false;

    $(".tabs__btns > li").on("click", function () {
      if (isClickHandled) {
        return;
      }

      if (!$(this).hasClass('active')) {
        isClickHandled = true;
        clearTimeout(timer);

        $(this).siblings("li").removeClass("active")
        $(this).addClass("active")
        const contentActive = $(this).parents('.tabs').find(".tabs__content li.active")
        contentActive.fadeOut(30, function () {
          $(this).parents('.tabs__content').find("li").removeClass("active")
          const btnActiveIndex = $(this).parents('.tabs').find(".tabs__btns .active").index()
          $(this).parents('.tabs__content').find("li").eq(btnActiveIndex).addClass("active")

          const contentActiveHeight = $(this).parents('.tabs').find(".tabs__content li.active").outerHeight()
          const wrapper = $(this).parents('.tabs').find(".tabs__content")
          wrapper.stop().animate({
            height: contentActiveHeight
          }, 150, function () {
            $(this).parents('.tabs__content').find(".tabs__content li.active").fadeIn(30)
            isClickHandled = false;
            timer = setTimeout(() => {
              isClickHandled = false;
            }, 200);
          })
        })
      }
    })
    $(window).on('resize', function () {
      getTabs()
    })
  }
  function getTabs() {
    for (let element of tabs) {
      const wrapper = $(element).find(".tabs__content")
      const contentActive = wrapper.find("li.active")
      const contentActiveHeight = contentActive.outerHeight()
      wrapper.height(contentActiveHeight)
      contentActive.show()
    }
  }
})
