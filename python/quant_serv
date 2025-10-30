import pandas as pd
import tkinter as tk
from tkinter import ttk, filedialog, messagebox



COLUNA_SERVICO = "TipoServico"
COLUNA_LOCALIDADE = "NomeCidade"
COLUNA_MATRICULA = "MatriculaImovel"




def processar_dados():

    # Obter dados da interface
    caminho_arquivo = entry_caminho_arquivo.get()

    if not caminho_arquivo:
        messagebox.showerror("Erro de Entrada", "Por favor, selecione um arquivo primeiro.")
        return


    tree.destroy()
    criar_treeview()

    label_status.config(text="Processando... Aguarde.", fg="blue")
    root.update_idletasks()

    #  Ler Planilha
    try:
        if caminho_arquivo.endswith('.xlsx'):
            df = pd.read_excel(caminho_arquivo, engine='openpyxl')
        elif caminho_arquivo.endswith('.csv'):
            df = pd.read_csv(caminho_arquivo, sep=None, engine='python')
        else:
            messagebox.showerror("Erro de Arquivo", "Formato de arquivo não suportado.")
            label_status.config(text="Falha.", fg="red")
            return

    except FileNotFoundError:
        messagebox.showerror("Erro", f"O arquivo '{caminho_arquivo}' não foi encontrado.")
        label_status.config(text="Falha.", fg="red")
        return
    except Exception as e:
        messagebox.showerror("Erro ao Ler Arquivo", f"Ocorreu um erro: {e}")
        label_status.config(text="Falha.", fg="red")
        return

    # Validar Colunas
    colunas_necessarias = [COLUNA_LOCALIDADE, COLUNA_MATRICULA, COLUNA_SERVICO]
    colunas_faltando = []

    for col in colunas_necessarias:
        if col not in df.columns:
            colunas_faltando.append(col)

    if colunas_faltando:
        messagebox.showerror("Erro de Coluna",
                             f"Não foi possível encontrar as colunas necessárias na planilha.\n\n"
                             f"Colunas não encontradas: {', '.join(colunas_faltando)}\n\n"
                             f"Verifique se sua planilha contém exatamente '{COLUNA_LOCALIDADE}', "
                             f"'{COLUNA_MATRICULA}' e '{COLUNA_SERVICO}'.")
        label_status.config(text="Falha. Colunas não encontradas.", fg="red")
        return

    # Processo Dados

    label_status.config(text=f"Criando tabela dinâmica (Serviço x Cidade)...", fg="blue")
    root.update_idletasks()

    try:

        layout_pivot = pd.pivot_table(
            df,
            values=COLUNA_MATRICULA,
            index=COLUNA_SERVICO,
            columns=COLUNA_LOCALIDADE,
            aggfunc='count',
            fill_value=0
        )


        layout_pivot['Total Geral'] = layout_pivot.sum(axis=1).astype(int)


        layout_final = layout_pivot.reset_index()
        layout_final = layout_final.rename_axis(columns=None)

    except Exception as e:
        messagebox.showerror("Erro ao Processar", f"Ocorreu um erro ao criar a tabela dinâmica: {e}")
        label_status.config(text="Falha.", fg="red")
        return


    try:
        nome_arquivo_saida = "relatorio_servico_x_cidade.xlsx"
        layout_final.to_excel(nome_arquivo_saida, index=False, engine='openpyxl')
    except Exception as e:
        messagebox.showwarning("Erro ao Salvar",
                               f"Não foi possível salvar o arquivo Excel '{nome_arquivo_saida}'.\nErro: {e}")



    lista_colunas = list(layout_final.columns)

    tree["columns"] = lista_colunas
    tree.column("#0", width=0, stretch=tk.NO)

    for col_nome in lista_colunas:
        largura = 100
        ancora = tk.CENTER


        if col_nome == COLUNA_SERVICO:
            largura = 180
            ancora = tk.W

        elif col_nome == "Total Geral":
            largura = 120

        tree.column(col_nome, anchor=ancora, width=largura)
        tree.heading(col_nome, text=col_nome, anchor=ancora)


    for index, row in layout_final.iterrows():
        tree.insert("", tk.END, values=tuple(row))

    label_status.config(text=f"Processamento concluído! Tabela dinâmica gerada. Relatório salvo.", fg="green")


def selecionar_arquivo():
    tipos_arquivo = (("Arquivos Excel", "*.xlsx"), ("Arquivos CSV", "*.csv"), ("Todos os arquivos", "*.*"))
    caminho = filedialog.askopenfilename(title="Selecione sua planilha", filetypes=tipos_arquivo)

    if caminho:
        entry_caminho_arquivo.delete(0, tk.END)
        entry_caminho_arquivo.insert(0, caminho)
        label_status.config(text="Arquivo selecionado. Clique em 'Gerar Relatório'.", fg="black")


def criar_treeview():

    global tree

    frame_tabela = ttk.Frame(frame_resultados)
    frame_tabela.pack(fill=tk.BOTH, expand=True)

    scrollbar_y = ttk.Scrollbar(frame_tabela, orient=tk.VERTICAL)
    scrollbar_x = ttk.Scrollbar(frame_tabela, orient=tk.HORIZONTAL)

    tree = ttk.Treeview(
        frame_tabela,
        yscrollcommand=scrollbar_y.set,
        xscrollcommand=scrollbar_x.set
    )

    scrollbar_y.config(command=tree.yview)
    scrollbar_x.config(command=tree.xview)

    scrollbar_y.pack(side=tk.RIGHT, fill=tk.Y)
    scrollbar_x.pack(side=tk.BOTTOM, fill=tk.X)
    tree.pack(fill=tk.BOTH, expand=True)


#   Interface

root = tk.Tk()
root.title("Relatório de Serviços por Cidade")
root.geometry("800x500")

frame_principal = ttk.Frame(root, padding="10")
frame_principal.pack(fill=tk.BOTH, expand=True)

#  Entrada de Arquivo
frame_arquivo = ttk.LabelFrame(frame_principal, text="Selecione o Arquivo", padding="10")
frame_arquivo.pack(fill=tk.X, expand=True, pady=5)

entry_caminho_arquivo = ttk.Entry(frame_arquivo, width=60)
entry_caminho_arquivo.pack(side=tk.LEFT, fill=tk.X, expand=True, padx=(0, 5))
btn_selecionar = ttk.Button(frame_arquivo, text="Selecionar...", command=selecionar_arquivo)
btn_selecionar.pack(side=tk.LEFT)


#  Botão de Processamento
btn_processar = ttk.Button(frame_principal, text="Gerar Relatório", command=processar_dados)
btn_processar.pack(pady=10, fill=tk.X)


frame_resultados = ttk.LabelFrame(frame_principal, text="Resultados: ", padding="10")
frame_resultados.pack(fill=tk.BOTH, expand=True, pady=5)

criar_treeview()


label_status = tk.Label(frame_principal, text="Pronto. Por favor, selecione um arquivo.", relief=tk.SUNKEN, anchor=tk.W)
label_status.pack(side=tk.BOTTOM, fill=tk.X, pady=(5, 0))


root.mainloop()
