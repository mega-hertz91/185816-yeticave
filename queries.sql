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

INSERT INTO lots (name, description, image, category_id, user_id, start_price, step_bet)
  VALUES (
  '2014 Rossignol District Snowboard',
  'Glass Fiber – Has greater elongation before break than carbon and comes in multiple ',
  'product/board/rossignol.png',
  1,
  2,
  11000,
  1000
  ),
  (
  'Куртка для сноуборда DC Mutiny Charocal',
  'Мужская сноубордическая куртка DC Ripley с ярким и стильным дизайном. Оснащена водостойкой',
  'product/board/jacked.png',
  4,
  5,
  8000,
  500
  ),
  (
  'Маска Oakley Canopy',
  'Маска с очень большой линзой, которая обеспечивает лучший обзор среди всех масок в линейке. Картинка будет четкой, контрастной и глубокой',
  'product/board/jacked.png',
  6,
  1,
  13000,
  2000
  ),
  (
  'Крепления Union Contact Pro 2015 года размер L/XL',
  'Крепления сноубордические мужские Union FACTORY (2015)',
  'product/board/jacked.png',
  2,
  3,
  7000,
  500
  );
