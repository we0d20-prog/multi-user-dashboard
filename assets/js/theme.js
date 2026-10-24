/* Theme Switcher */

const html = document.documentElement;
const themeToggle = document.getElementById("themeToggle");
const themeIcon = document.getElementById("themeIcon");
const themeText = document.getElementById("themeText");

/* قراءة الثيم المحفوظ */
const savedTheme = localStorage.getItem("theme") || "light";

/* تحديث ألوان الجداول */
function updateTables(theme){

    const tableHeaders = document.querySelectorAll(
        "table thead, table thead th, table thead td"
    );

    tableHeaders.forEach(function(element){

        if(theme === "dark"){

            element.style.setProperty(
                "background-color",
                "#343a40",
                "important"
            );

            element.style.setProperty(
                "color",
                "#ffffff",
                "important"
            );

            element.style.setProperty(
                "border-color",
                "#495057",
                "important"
            );

        }else{

            /* إزالة التنسيق الذي أضفناه في الوضع الليلي */
            element.style.removeProperty("background-color");
            element.style.removeProperty("color");
            element.style.removeProperty("border-color");

        }

    });
}

/* تطبيق الثيم */
function applyTheme(theme){

    html.setAttribute("data-bs-theme", theme);

    if(themeIcon){

        if(theme === "dark"){
            themeIcon.className = "fa fa-sun";
        }else{
            themeIcon.className = "fa fa-moon";
        }

    }

    if(themeText){

        if(theme === "dark"){
            themeText.textContent = "Light Mode";
        }else{
            themeText.textContent = "Dark Mode";
        }

    }

    /* تحديث ألوان الجداول */
    updateTables(theme);
}

/* تطبيق الثيم عند فتح الصفحة */
applyTheme(savedTheme);

/* زر تغيير الثيم */
if(themeToggle){

    themeToggle.addEventListener("click",function(){

        const currentTheme =
            html.getAttribute("data-bs-theme") || "light";

        const newTheme =
            currentTheme === "dark" ? "light" : "dark";

        /* حفظ الثيم */
        localStorage.setItem("theme",newTheme);

        /* تطبيق الثيم */
        applyTheme(newTheme);

    });

}