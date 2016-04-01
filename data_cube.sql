DROP VIEW data_cube;
create view data_cube as
   select owner_name, subject, extract(year from timing) as tYear, extract(month from timing)
   as tMonth, to_number(to_char(timing,'WW')) as tWeek, count(owner_name) as image_count
   from images
   group by cube (owner_name, subject, timing, extract(year from timing),
      extract(month from timing), to_number(to_char(timing,'WW')));