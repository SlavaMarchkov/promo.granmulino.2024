import { reactive } from 'vue';

export function useArrayHandlers() {
    const sortBy = reactive({
        column: 'id',
        asc: true,
        numeric: true,
    });

    const resetSearchKeys = (obj) => {
        for (const key in obj) {
            obj[key] = (key.startsWith('is')) ? false : '';
        }
    };

    const resetSortKeys = (
        column = 'id',
        asc = true,
        numeric = true,
    ) => {
        sortBy.column = column;
        sortBy.asc = asc;
        sortBy.numeric = numeric;
    };

    const filterArray = (arr, obj) => {
        let tempArr = arr.slice();

        for (const key in obj) {
            if (key.startsWith('is') && obj[key] === true) {
                tempArr = tempArr.filter(item => item[key] === true);
            } else if (!key.startsWith('is') && obj[key] !== '') {
                if (key.endsWith('Id')) {
                    tempArr = tempArr.filter(item => item[key] === parseInt(obj[key], 10));
                } else if (key === 'type') {
                    tempArr = tempArr.filter(item => item[key] === obj[key]);
                } else {
                    tempArr = tempArr.filter(item => {
                        if ( item[key] !== null ) {
                            return item[key].toLowerCase().includes(obj[key].toLowerCase());
                        }
                    });
                }
            }
        }

        return tempArr;
    };

    const setSort = (
        key = 'id',
        sort_by_numeric = true,
    ) => {
        sortBy.numeric = sort_by_numeric;
        if ( sortBy.column === key ) {
            if ( sortBy.asc === true ) sortBy.asc = false;
            else sortBy.asc = sortBy.asc === false;
        } else {
            sortBy.column = key;
            sortBy.asc = false;
        }
    };

    const sortArray = (arr) => {
        let tempArr = arr.slice();

        return tempArr.sort((a, b) => {
            if ( sortBy.numeric ) {
                return sortBy.asc
                    ? a[sortBy.column] - b[sortBy.column]
                    : b[sortBy.column] - a[sortBy.column];
            } else {
                const fa = a[sortBy.column].toLowerCase();
                const fb = b[sortBy.column].toLowerCase();

                return sortBy.asc
                    ? fa.localeCompare(fb)
                    : fb.localeCompare(fa);
            }
        });
    };

    return {
        sortBy,
        setSort,
        resetSearchKeys,
        resetSortKeys,
        filterArray,
        sortArray,
    };
}
