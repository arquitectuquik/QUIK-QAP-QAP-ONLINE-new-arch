FROM mysql:5.7.44

ENV MYSQL_ROOT_PASSWORD=rootpassword123
ENV MYSQL_DATABASE=u669796078_panequik_qap
ENV MYSQL_USER=u669796078_panequik_qap
ENV MYSQL_PASSWORD=QuikSAS2019*
ENV TZ=America/Bogota

COPY ./database/panequik_qaponline_v4.sql /docker-entrypoint-initdb.d/
COPY ./database/mysql.cnf /etc/mysql/conf.d/custom.cnf

RUN chmod 644 /etc/mysql/conf.d/custom.cnf && chown mysql:mysql /etc/mysql/conf.d/custom.cnf

EXPOSE 3306
CMD ["mysqld"]
