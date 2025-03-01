insert into channels (id, slug, name, is_for_retail, created_at, updated_at)
values  (1, 'chain_store', 'Сеть', 1, null, null),
        (2, 'retail', 'Розница', 0, null, null),
        (3, 'wholesale', 'Опт', 0, null, null),
        (4, 'wholesale_retail', 'Опт / Розница', 0, null, null),
        (5, 'wholesale_retail_chain_store', 'Опт / Розница / Сеть', 1, null, null),
        (6, 'e_shop', 'Интернет-магазин', 1, null, null),
        (7, 'horeca', 'HoReCa', 0, null, null);
