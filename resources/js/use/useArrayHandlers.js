export function useArrayHandlers() {
    const resetSearchKeys = (obj) => {
        for (const key in obj) {
            obj[key] = (key.startsWith('is')) ? false : '';
        }
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
                    // TODO: TypeError: Cannot read properties of null (reading 'toLowerCase')
                    tempArr = tempArr.filter(item => item[key].toLowerCase().includes(obj[key].toLowerCase()));
                }
            }
        }

        return tempArr;
    };

    const sortArray = (tempArr, sort_by_numeric, direction, column) => {
        return tempArr.sort((a, b) => {
            if (sort_by_numeric) {
                return direction === 'asc'
                    ? a[column] - b[column]
                    : b[column] - a[column];
            } else {
                const fa = a[column].toLowerCase();
                const fb = b[column].toLowerCase();

                return direction === 'asc'
                    ? fa.localeCompare(fb)
                    : fb.localeCompare(fa);
            }
        });
    };

    return {
        resetSearchKeys,
        filterArray,
    };
}
