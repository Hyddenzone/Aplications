from api_bcb import get_dados_bcb
from datetime import datetime

def analisar_selic(data_inicio, data_fim):
    
   
    codigo_selic = 11
    
    df_selic = get_dados_bcb(codigo_selic, data_inicio, data_fim)
    
    if df_selic is not None and not df_selic.empty:
        print("\n--- Análise da Taxa SELIC ---")
        print(f"Período: {data_inicio} a {data_fim}\n")
        
        print("Estatísticas Básicas:")
        print(df_selic['valor'].describe())
        
        
        valor_recente = df_selic.iloc[-1]
        print(f"\nValor mais recente ({valor_recente.name.strftime('%d/%m/%Y')}): {valor_recente['valor']}%")

        
        df_selic['media_movel_60d'] = df_selic['valor'].rolling(window=60).mean()
        
        print("\nÚltimos 5 registros (com média móvel de 60 dias):")
        print(df_selic.tail(5))
        
    else:
        print("Não foi possível realizar a análise da SELIC.")


if __name__ == "__main__":
    
    hoje = datetime.now().strftime('%d/%m/%Y')
    
    
    analisar_selic(data_inicio="01/01/2023", data_fim=hoje)



