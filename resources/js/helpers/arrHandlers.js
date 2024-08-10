// TODO: доработать сортировку по кликам isActive
export const arrFilter = (tempArr, searchArr) => {
    for ( const key in searchArr ) {
        if ( key === 'isActive' && searchArr[key] === true ) {
            tempArr = tempArr.filter(item => item[key] === true);
        } else if ( key.endsWith('Id') && searchArr[key] !== '' ) {
            tempArr = tempArr.filter(item => item[key] === parseInt(searchArr[key], 10));
        } else if ( key !== 'isActive' && searchArr[key] !== '' ) {
            tempArr = tempArr.filter(item => item[key].toLowerCase().includes(searchArr[key].toLowerCase()));
        }
    }

    return tempArr;
};

export const arrSort = (tempArr, sort_by_numeric, orderDirection, column) => {
    return tempArr.sort((a, b) => {
        if ( sort_by_numeric ) {
            return orderDirection === 'asc'
                ? a[column] - b[column]
                : b[column] - a[column];
        } else {
            const fa = a[column].toLowerCase();
            const fb = b[column].toLowerCase();

            return orderDirection === 'asc'
                ? fa.localeCompare(fb)
                : fb.localeCompare(fa);
        }
    });
};
