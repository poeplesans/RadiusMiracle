import mysql.connector as mysql
from mysql.connector import Error
from dotenv import load_dotenv
import os
import json

# Load environment variables from .env file
load_dotenv()


class Database:
    def __init__(self):
        self.host = os.getenv('DB_HOST')
        self.port = os.getenv('DB_PORT')
        self.user = os.getenv('DB_USERNAME')
        self.password = os.getenv('DB_PASSWORD')
        self.database = 'tenantmiracle'
        self.table = 'query_datas'

    def connect(self):
        db = mysql.connect(
            host=self.host,
            port=self.port,
            user=self.user,
            password=self.password,
            database=self.database
        )
        try:
            if db.is_connected():
                print("Connected to MySQL database")
                return db
        except Error as e:
            print(f"Error: {e}")
            # self.connection = None

    def insert_data(self, key, data):
        mysql_connect = self.connect()
        if not mysql_connect or not mysql_connect.is_connected():
            print("No connection to MySQL database")
            return

        try:
            cursor = mysql_connect.cursor(dictionary=True)

            # Check if the table exists
            cursor.execute(f"SHOW TABLES LIKE '{self.table}'")
            result = cursor.fetchone()
            if not result:
                # Create table if it does not exist
                cursor.execute(f"""
                    CREATE TABLE IF NOT EXISTS {self.table} (
                        `key` INT NOT NULL,
                        `data` JSON NOT NULL
                    )
                """)
                print(f"Table `{self.table}` created successfully")

            # Convert the data to a JSON string
            data_json = json.dumps(data)

            # Menyiapkan perintah SQL
            sql = f"""
                INSERT INTO {self.table} (`key`, `data`, `created_at`, `updated_at`) 
                VALUES (%s, %s, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
                ON DUPLICATE KEY UPDATE 
                    `data` = VALUES(`data`),
                    `updated_at` = CURRENT_TIMESTAMP
            """

            # Menjalankan perintah SQL
            cursor.execute(sql, (key, data_json))

            mysql_connect.commit()
            return "Data inserted/updated successfully"
        except Error as e:
            return f"Failed to insert/update data into MySQL table {self.table}: {e}"
        finally:
            if cursor:
                cursor.close()

    def run_database(self):
        self.insert_data('query_datas', data)

    def getRouter(self,id):
        mysql_connect = self.connect()
        if not mysql_connect or not mysql_connect.is_connected():
            print("No connection to MySQL database")
            return
        try:
            cursor = mysql_connect.cursor(dictionary=True)
            # id = 1  # Ganti dengan ID yang Anda inginkan
            table_name = 'router'
            query = "SELECT * FROM {} WHERE id = {}".format(table_name, id)
            cursor.execute(query)

            # Ambil data dari hasil query
            data = cursor.fetchone()
            return data
        except Error as e:
             print(f"Failed to insert/update data into MySQL table {table}: {e}")
        finally:
            if cursor:
                cursor.close()


data = [
    {'id': 1, 'data': {'key1': 'value1', 'key2': 'value2'}},
    {'id': 2, 'data': {'key1': 'value3', 'key2': 'value4'}}
]

# db_manager = Database()
# # mysql_connect = db_manager.insert_data('query_datas',data)
# mysql_connect = db_manager.getRouter(1)
# print(mysql_connect)
# # db_manager.disconnect(mysql_connect)
