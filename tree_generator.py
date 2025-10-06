import os

# Íconos
ICON_FOLDER = "📁"
ICON_FILE = "📄"
ICON_PYTHON = "🐍"
ICON_REACT = "⚛️"

# Carpetas a excluir
EXCLUDE_DIRS = ['data_seeding', 'venv', 'node_modules', '__pycache__', '.git', '.idea', 'dist', 'build', 'out', 'imagenes',
                'lib', 'bin', 'obj', '.vscode', '.pytest_cache', '.mypy_cache', '.tox', '.eggs', "out", 'svgs', 'tutorial', 
                'egg-info', '.pytest', '.coverage', '.coverage.*', 'coverage_html_report', 'htmlcov', 'temp_chart', 'fpdf',
                'docs', 'doc', 'docs_build', 'docs_source', 'docs_output', 'docs_html', 'docs_pdf', 'target', 'temp_charts',
                'docs_rst', 'docs_markdown', 'docs_sphinx', 'docs_jupyter', 'docs_notebooks', ".next", 'tcpdf', 'css',
                'docs_jupyter_notebooks', 'docs_jupyterlab', 'docs_jupyterlab_notebooks', 'docs_jupyterlab_html', 'boostrap',
                'docs_jupyterlab_pdf', 'docs_jupyterlab_rst', 'docs_jupyterlab_markdown', 'docs_jupyterlab_sphinx','src-tauri',]

output_lines = []

def formatear_tamaño(bytes):
    """Convierte bytes a formato legible (KB, MB, GB)"""
    if bytes < 1024:
        return f"{bytes}B"
    elif bytes < 1024**2:
        return f"{bytes/1024:.1f}KB"
    elif bytes < 1024**3:
        return f"{bytes/(1024**2):.1f}MB"
    else:
        return f"{bytes/(1024**3):.1f}GB"

def listar_directorio(ruta, prefijo="", es_ultima=False, mostrar_linea_padre=False):
    entradas = sorted([
        e for e in os.listdir(ruta)
        if e not in EXCLUDE_DIRS
    ])
    
    archivos = [e for e in entradas if os.path.isfile(os.path.join(ruta, e))]
    carpetas = [e for e in entradas if os.path.isdir(os.path.join(ruta, e))]

    # Detectamos si hay carpetas, para saber si se deben dibujar líneas en archivos
    tiene_subcarpetas = len(carpetas) > 0

    # Mostrar archivos primero
    for archivo in archivos:
        icono = ICON_FILE
        if archivo.endswith(".py"):
            icono = ICON_PYTHON
        elif archivo.endswith(".jsx") or archivo.endswith(".tsx"):
            icono = ICON_REACT

        # Obtener el tamaño del archivo
        ruta_archivo = os.path.join(ruta, archivo)
        try:
            tamaño = os.path.getsize(ruta_archivo)
            tamaño_formateado = formatear_tamaño(tamaño)
        except OSError:
            tamaño_formateado = "N/A"

        linea = f"{prefijo}{'│   ' if tiene_subcarpetas else '    '}{icono} {archivo} {tamaño_formateado}"
        output_lines.append(linea)

    # Ahora las carpetas
    total = len(carpetas)
    for i, carpeta in enumerate(carpetas):
        ruta_carpeta = os.path.join(ruta, carpeta)
        es_ultima_carpeta = i == (total - 1)

        conector = "└── " if es_ultima_carpeta else "├── "
        output_lines.append(f"{prefijo}{conector}{ICON_FOLDER} {carpeta}")

        nuevo_prefijo = prefijo + ("    " if es_ultima_carpeta else "│   ")
        listar_directorio(ruta_carpeta, nuevo_prefijo, es_ultima_carpeta)

if __name__ == "__main__":
    ruta_actual = os.path.dirname(os.path.abspath(__file__))
    nombre_raiz = os.path.basename(ruta_actual)

    output_lines.append(f"{ICON_FOLDER} {nombre_raiz}")
    listar_directorio(ruta_actual)

    with open("estructura.txt", "w", encoding="utf-8") as f:
        f.write("\n".join(output_lines))

    print("\n".join(output_lines))