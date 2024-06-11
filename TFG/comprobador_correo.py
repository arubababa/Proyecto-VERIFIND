import sys
import random
import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

def enviar_correo(email):
    # Genera un número entero aleatorio de 6 dígitos.
    numero_aleatorio = str(random.randint(100000, 999999))

    # Configura los detalles del servidor SMTP de Gmail.
    smtp_host = 'smtp.gmail.com'
    smtp_port = 587
    smtp_username = 'verifind.oficial.eu@gmail.com'  # Cambia esto por tu correo electrónico de Gmail.
    smtp_password = 'cftw jscx fsrx xqte'  # Cambia esto por tu contraseña de Gmail.

    # Configura el mensaje.
    from_email = 'verifind.oficial.eu@gmail.com' # Cambia esto por el correo electrónico del remitente.
    to_email = email
    subject = 'Verificación del correo'
    message = f"Este es su código de verificación: {numero_aleatorio}"

    # Crea un objeto MIMEMultipart y configura el mensaje.
    msg = MIMEMultipart()
    msg['From'] = from_email
    msg['To'] = to_email
    msg['Subject'] = subject
    msg.attach(MIMEText(message, 'plain'))

    # Envía el correo electrónico.
    try:
        with smtplib.SMTP(smtp_host, smtp_port) as server:
            server.starttls()
            server.login(smtp_username, smtp_password)
            server.sendmail(from_email, to_email, msg.as_string())
        print("El correo electrónico se ha enviado correctamente.")

        return numero_aleatorio

    except smtplib.SMTPException as e:
        print("Ocurrió un error al enviar el correo electrónico:", str(e))
        return False

enviar_correo(sys.argv[1])