INSERT INTO users (nikname, email, password, contact, avatar)
 VALUES (
 'Ricentwo',
 'Ricentwo-4181@yopmail.com',
 'Ricentwo-4181',
 'Попова Роза Григорьевна, 13 сентября 1972 года, 8 (903) 500-82-24',
 'avatar/popova.png'
 ),
 (
 'Ocollojir',
 'Dcollojir-0780@yopmail.com',
 'Ocollojir-0780',
 'Александрова Элина Артемовна, 24 марта 1983 года',
 'avatar/elina.png'
 ),
 (
 'Qurrellizaha',
 'Qurrellizaha-0662@yopmail.com',
 'Qurrellizaha-0662',
 'Васютин Сила Ярославович, 8 июня 1981 года, 8 (909) 496-14-98',
 'avatar/vasyta.png'
 ),
 (
 'Amullowa',
 'Amullowa-6503@yopmail.com',
 'Amullowa-6503', 'Андреев Георгий Тарасович, 8 (901) 820-77-91',
 'avatar/andreev.png'
 ),
 (
 'Denubipac',
 'Denubipac-6324@yopmail.com',
 'denubipac-632',
 'Григорьева Станислава Анатольевна, 8 (905) 201-66-63',
 'avatar/stasya.png'
 );

INSERT INTO categories (name)
  VALUE ('Доски и лыжи'),
  ('Крепления'),
  ('Ботинки'),
  ('Одежда'),
  ('Инструменты'),
  ('Разное');

INSERT INTO lots (name, description, image, category_id, user_id, start_price, step_bet, start_date, finish_date)
VALUES (
           '2014 Rossignol District Snowboard',
           'Glass Fiber – Has greater elongation before break than carbon and comes in multiple ',
           'img/lot-1.jpg',
           1,
           2,
           10999,
           1000,
           '2019-01-20 09:00:00',
           '2019-03-02 00:00:00'
           ),
       (
           'DC Ply Mens 2016/2017 Snowboard',
           'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
           'img/lot-2.jpg',
           1,
           5,
           159999,
           10000,
           '2019-02-10 09:00:00',
           '2019-02-14 00:00:00'
           ),
       (
           'Крепления Union Contact Pro 2015 года размер L/XL',
           'Крепления сноубордические мужские Union FACTORY (2015)',
           'img/lot-3.jpg',
           2,
           3,
           8000,
           500,
           '2019-01-30 09:00:00',
           '2019-03-14 00:00:00'
           ),
       (
           'Ботинки для сноуборда DC Mutiny Charocal',
           'Curabitur aliquam porta mauris sed commodo',
           'img/lot-4.jpg',
           3,
           4,
           10999,

           1000,
           '2019-01-20 09:00:00',
           '2019-02-02 00:00:00'
           ),
       (
           'Куртка для сноуборда DC Mutiny Charocal',
           'Proin scelerisque imperdiet lectus a porta',
           'img/lot-5.jpg',
           4,
           4,
           7500,
           500,
           '2019-01-20 09:00:00',
           '2019-02-02 00:00:00'
           ),
       (
           'Маска Oakley Canopy',
           'Маска с очень большой линзой, которая обеспечивает лучший обзор среди всех масок в линейке. Картинка будет четкой, контрастной и глубокой',
           'img/lot-6.jpg',
           6,
           1,
           5400,
           500,
           '2019-01-20 09:00:00',
           '2019-02-02 00:00:00'
           );

INSERT INTO bets (price_bet, user_id, lot_id, date_bet)
  VALUES (12000, 2, 3, '2019-02-09 09:00:00'),
  (7500, 3, 6, '2019-02-08 08:00:00'),
  (15000, 5, 4, '2019-02-11 13:30:00'),
  (15000, 2, 3, '2019-02-11 13:30:00'),
  (13000, 2, 4, '2019-02-11 13:30:00'),
  (12000, 1, 1, '2019-02-11 13:30:00');

/*Вывод всех категорий*/

SELECT * FROM categories;

/*Вывод актуальных лотов*/

SELECT b.lot_id, l.name, l.start_price, l.image, c.name as category, MAX(b.price_bet) AS current_price FROM lots l
JOIN bets b
ON b.lot_id = l.id
JOIN categories c
ON l.category_id = c.id
WHERE l.finish_date > NOW()
GROUP BY b.lot_id;

/*Выбор лота по id*/

SELECT l.id, l.name, l.category_id, c.name, u.nikname, l.start_price, l.image FROM lots l
JOIN categories c
ON l.category_id = c.id
JOIN users u
ON l.user_id = u.id
WHERE l.id = 4;

/*Обновление имени лота по id*/

UPDATE lots SET name = 'DC Ply Mens 2017/2018'
WHERE id = 2;

/*Список самых свежих ставок для лота*/

SELECT b.id, b.price_bet, b.user_id, b.lot_id, l.name, b.date_bet FROM bets b
JOIN lots l
ON b.id = l.id
WHERE l.id = 3
ORDER BY date_bet DESC;

