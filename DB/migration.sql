INSERT INTO my_news_2014 (n_id, n_solder, n_head, n_subhead, news_tags, n_author, n_writer, n_reporter, n_details, n_category, main_image, watermark, n_caption, category_lead, home_lead, highlight_items, focus_items, pin_news, ticker_news, home_category, is_latest, cat_selected, home_slide, multimedia_slide, sticky, title_info, meta_keyword, meta_description, embedded_code, main_video, most_read, divisions, districts, upazilas, n_status, n_order, home_cat_order, leadnews_order, highlight_order, focus_order, pin_order, special_order, home_slide_order, multimedia_slide_order, edition, n_date, start_at, end_at, edit_at, updated_by, onediting, is_live, is_active_live, is_linked, parent_id, created_at, updated_at, deleted_by, deleted_at, restore_by, created_by)
SELECT
    o_n.n_id,
    o_n.sholder,
    o_n.head,
    o_n.subhead,
    NULL, -- news_tags (empty string as value)
    o_n.author,
    NULL,
    NULL, -- n_reporter (empty string as value)
    o_n.details,
    o_n.category,
    o_n.img AS main_image, -- এখানে o_n.img ব্যবহার করা হয়েছে
    1, -- watermark
    o_n.caption,
    1, -- category_lead
    1, -- home_lead
    1, -- highlight_items
    1, -- focus_items
    1, -- pin_news
    0, -- ticker_news
    1, -- home_category
    1, -- is_latest
    0, -- cat_selected
    1, -- home_slide
    1, -- multimedia_slide
    0, -- sticky
    NULL, -- title_info (empty string as value)
    o_n.meta_keyword,
    o_n.meta_description,
    o_n.embedded_code,
    0, -- main_video
    o_n.most_read,
    NULL,
    NULL,
    NULL,
    o_n.status,
    o_n.n_id, -- n_order
    o_n.n_id, -- home_cat_order
    o_n.n_id, -- leadnews_order
    o_n.n_id, -- highlight_order
    o_n.n_id, -- focus_order
    o_n.n_id, -- pin_order
    o_n.n_id, -- special_order
    o_n.n_id, -- home_slide_order
    o_n.n_id, -- multimedia_slide_order
    'online', -- edition
    o_n.date,
    o_n.start_date,
    NULL,
    NULL, -- edit_at (empty string as value)
    0, -- updated_by
    0, -- onediting
    0, -- is_live
    0, -- is_active_live
    1, -- is_linked
    0,
    o_n.created_at,
    o_n.updated_at,
    NULL,
    NULL,
    NULL,
    usr.id AS created_by -- created_by
FROM
    news_2014 AS o_n
JOIN
    users AS usr ON o_n.post_by = usr.email;


INSERT INTO my_menus (m_id ,m_name ,slug ,m_edition ,m_title ,m_keywords ,m_desc ,m_parent ,m_order ,m_status ,m_visible ,s_news ,m_color ,m_bg ,created_by ,updated_by ,created_at ,updated_at ,deleted_by ,deleted_at)
SELECT
    id
    ,display_menu
    ,workable_menu
    ,'online'
    ,display_menu
    ,''
    ,''
    ,0
    ,0
    ,status
    ,0
    ,NULL
    ,''
    ,''
    ,created_by
    ,NULL
    ,created_at
    ,NULL
    ,NULL
    ,NULL
FROM
    menu




INSERT INTO my_users (id, name, email, password, two_factor_secret, two_factor_recovery_codes, img, designation, role, type, status, folder_location, watermark_ad, created_by, updated_by, email_verified_at, remember_token, created_at, updated_at)
SELECT id, name, email, password, NULL, NULL, NULL, NULL, 'subscriber', 'online', status, NULL, 0, 1, NULL, NULL, remember_token, created_at, updated_at FROM users
