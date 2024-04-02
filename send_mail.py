import smtplib
from email.mime.multipart import MIMEMultipart 
from email.mime.text import MIMEText 
from email.mime.base import MIMEBase 
from email import encoders 
import datetime
import ssl

import mysql.connector

conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="12345678",
    database="memmo"
)

if conn.is_connected():
    cursor = conn.cursor()

    
    cursor.execute("SELECT * FROM memmo_list")

    
    rows = cursor.fetchall()
    #(15, 'andy', datetime.datetime(2024, 3, 1, 18, 28), '寄信', '要寄信', 0, 0)
    
    for row_memmo in rows:
        if row_memmo[5]==1:
            cursor.execute("SELECT email FROM user WHERE user_name = "+"'"+row_memmo[1]+"'")
            row_user = cursor.fetchone()
            
            
            
            today_date = datetime.datetime.today()
            duration = row_memmo[2]-today_date
            hour = duration.seconds/3600
            print(duration)
            if hour < 1 :
                
                gmail_user = 'andyssvs015@gmail.com'
                gmail_password = 'secret' #app password
                from_address = gmail_user
                    
                
                to_address = [gmail_user]  
                Subject = row_memmo[3]+"({})".format(today_date)
                contents = row_memmo[4]
                
                
                #attachments = ['path\\Play report {}.xlsx'.format(last_mon)]
    
                
                #開始組合信件內容
                mail = MIMEMultipart()
                mail['From'] = from_address
                mail['To'] = ', '.join(to_address)
                mail['Subject'] = Subject
                
                mail.attach(MIMEText(contents))     
                  
                '''for file in attachments:
                    with open(file, 'rb') as fp:
                        add_file = MIMEBase('application', "octet-stream")
                        add_file.set_payload(fp.read())
                    encoders.encode_base64(add_file)
                    add_file.add_header('Content-Disposition', 'attachment', filename='Play report {}.xlsx'.format(last_mon))
                    mail.attach(add_file)'''
                

                   
                smtpserver = smtplib.SMTP_SSL("smtp.gmail.com", 465)
                smtpserver.ehlo()
                smtpserver.login(gmail_user, gmail_password)
                smtpserver.sendmail(from_address, to_address, mail.as_string())
                smtpserver.quit()



    cursor.close()
    conn.close()

