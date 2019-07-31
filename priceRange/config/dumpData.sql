CREATE TABLE IF NOT EXISTS prices(
    price_id int NOT NULL AUTO_INCREMENT,
    start_date date NOT NULL,
    end_date date NOT NULL,
    price float NOT NULL,
    PRIMARY KEY (price_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO prices(start_date, end_date, price)
VALUES ('2019-01-01', '2019-01-20', 15.0);
INSERT INTO prices(start_date, end_date, price)
VALUES ('2019-02-01', '2019-02-05', 25.2);
INSERT INTO prices(start_date, end_date, price)
VALUES ('2019-03-01', '2019-03-10', 16.8);