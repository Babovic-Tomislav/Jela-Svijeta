Jela svijeta application that shows meals depending on parameters in url.

#Parameters can be
#lang(required),
#with(optional, valuse - tags,category,ingredients)
#tags(optional, list of id's of tags we wish to filter our meals)
#category(optional, id of category we wish to filter our meals, also can be NULL or !NULL depending if we want meals with category or without)
#per_page(optional, meals per page)
#page(optional, page number))
#diff_time(optional, UNIX timestamp to filter our meals that are created,updated or deleted after that stamp) 