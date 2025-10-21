

import requests
import pandas as pd
from datetime import datetime

def get_dados_bcb(codigo_serie, data_inicio, data_fim):
    
    print(f"Buscando dados para a série {codigo_serie}...")
    
   
    url = f"https://api.bcb.gov.br/dados/serie/bcdata.sgs.{codigo_serie}/dados?formato=json&dataInicial={data_inicio}&dataFinal={data_fim}"
    
    try:
        
        response = requests.get(url)
        response.raise_for_status() 
        
      
        dados_json = response.json()
        if not dados_json:
            print("Nenhum dado retornado para o período.")
            return None
            
        df = pd.DataFrame(dados_json)
        
       
        df['data'] = pd.to_datetime(df['data'], format='%d/%m/%Y')
        
        
        df['valor'] = pd.to_numeric(df['valor'])
        
       
        df.set_index('data', inplace=True)
        
        print("Dados processados com sucesso.")
        return df

    except requests.exceptions.RequestException as e:
        print(f"Erro ao buscar dados da API: {e}")
        return None
    except Exception as e:
        print(f"Erro ao processar os dados: {e}")
        return None
