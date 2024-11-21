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
                            return Number.isInteger(item[key])
                                ? item[key] <= parseInt(obj[key], 10)
                                : item[key].toLowerCase().includes(obj[key].toLowerCase());
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
                const fa = a[sortBy.column] ? a[sortBy.column].toLowerCase() : '';
                const fb = b[sortBy.column] ? b[sortBy.column].toLowerCase() : '';

                return sortBy.asc
                    ? fa.localeCompare(fb)
                    : fb.localeCompare(fa);
            }
        });
    };

    const sortArrayByStringColumn = (arr, column) => {
        let tempArr = arr.slice();

        return tempArr.sort((a, b) => {
            const fa = a[column].toLowerCase();
            const fb = b[column].toLowerCase();
            return (fa < fb) ? -1 : (fa > fb) ? 1 : 0;
        });
    };

    const sortArrayByBoolean = (arr, column) => {
        let tempArr = arr.slice();

        return tempArr.sort((x, y) => {
            return (x[column] === y[column]) ? 0 : x[column] ? -1 : 1;
        });
    };

    const getUniqueObjectsFromArray = (arr) => {
        let tempArr = arr.slice();

        return tempArr.reduce((accumulator, current) => {
            if ( accumulator.findIndex(object => object.id === current.id) === -1 ) {
                accumulator.push(current);
            }
            return accumulator;
        }, []);
    };

    return {
        sortBy,
        setSort,
        resetSearchKeys,
        resetSortKeys,
        filterArray,
        sortArray,
        sortArrayByStringColumn,
        sortArrayByBoolean,
        getUniqueObjectsFromArray,
    };
}
