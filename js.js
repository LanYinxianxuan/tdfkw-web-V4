// 找到所有带 .fade-in 类的元素
const elements = document.querySelectorAll(".fade-in");

// 定义元素
function checkScroll() {
  elements.forEach((el) => {
    const rect = el.getBoundingClientRect();
    if (rect.top < window.innerHeight - 50) {
      el.classList.add("active"); //  active 类
    }
  });
}

// 监听滚动和加载事件
window.addEventListener("scroll", checkScroll);
window.addEventListener("load", checkScroll);
