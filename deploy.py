import os
import subprocess
from ftplib import FTP
from dotenv import load_dotenv

# Cargar variables de .env
load_dotenv()

FTP_HOST = os.getenv("FTP_HOST")
FTP_USER = os.getenv("FTP_USER")
FTP_PASS = os.getenv("FTP_PASS")
FTP_DIR = os.getenv("FTP_DIR")

# Obtener lista de archivos modificados según git
changed_files = subprocess.check_output(
    ["git", "diff", "--name-only", "origin/main"]
).decode("utf-8").splitlines()

if not changed_files:
    print("✅ No hay archivos modificados para subir.")
    exit()

print("Archivos a subir:", changed_files)

# Conexión FTP
ftp = FTP(FTP_HOST)
ftp.login(FTP_USER, FTP_PASS)
ftp.cwd(FTP_DIR)
print("✅ Conectado al servidor FTP")

def upload_file(local_path):
    remote_path = local_path.replace("\\", "/")
    remote_dirs = remote_path.split("/")[:-1]

    # Crear directorios remotos si no existen
    path_so_far = ""
    for d in remote_dirs:
        if d:
            path_so_far += "/" + d
            try:
                ftp.mkd(path_so_far)
            except:
                pass  # si ya existe, ignoramos

    # Subir archivo
    with open(local_path, "rb") as f:
        ftp.storbinary(f"STOR {remote_path}", f)
        print(f"Subido: {remote_path}")

# Subir cada archivo modificado
for file_path in changed_files:
    if os.path.isfile(file_path):
        upload_file(file_path)

ftp.quit()
print("🚀 Deploy de archivos modificados completado")
