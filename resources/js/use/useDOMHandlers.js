import { useRoute } from "vue-router";

export function useDOMHandlers() {
    const route = useRoute();

    const closeOpenedMenuItems = () => {
        const collapseElementList = document.querySelectorAll('.collapse');
        collapseElementList.forEach(el => {
            const collapsedElement = el.previousElementSibling;
            el.classList.remove('show');
            collapsedElement.classList.add('collapsed');
        });
    };

    const openActiveRouteMenuItem = () => {
        const routeNameList = document.querySelectorAll('ul.nav-content > li > a');
        routeNameList.forEach(el => {
            if ( el.id === route.name || el.id.startsWith(route.name.split('.')[0]) ) {
                el.classList.add('active');
                el.parentElement.parentElement.classList.add('show');
                el.parentElement.parentElement.previousElementSibling.classList.remove('collapsed');
            }
        });
    };

    const toggleSidebar = () => {
        document.querySelector('body').classList.toggle('toggle-sidebar');
    };

    const collapse = (element) => {
        const collapseElementList = document.querySelectorAll('.collapse');
        collapseElementList.forEach(el => {
            const collapsedElement = el.previousElementSibling;
            if ( el.id === element ) {
                el.classList.toggle('show');
                collapsedElement.classList.toggle('collapsed');
            } else {
                el.classList.remove('show');
                collapsedElement.classList.add('collapsed');
            }
        });
    };

    return {
        toggleSidebar,
        closeOpenedMenuItems,
        openActiveRouteMenuItem,
        collapse,
    };
}
