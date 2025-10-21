public class Conta {

 
    private String numeroConta;
    private String nomeTitular;
    private double saldo;

    
    public Conta(String numeroConta, String nomeTitular, double saldoInicial) {
        this.numeroConta = numeroConta;
        this.nomeTitular = nomeTitular;
        this.saldo = saldoInicial;
    }

   
     */
    public void depositar(double valor) {
        if (valor > 0) {
            this.saldo += valor;
            System.out.println("Depósito de R$" + valor + " realizado com sucesso.");
        } else {
            System.out.println("Valor de depósito inválido.");
        }
    }

    
    public boolean sacar(double valor) {
        if (valor <= 0) {
            System.out.println("Valor de saque inválido.");
            return false;
        }

        if (this.saldo >= valor) {
            this.saldo -= valor;
            System.out.println("Saque de R$" + valor + " realizado com sucesso.");
            return true;
        } else {
            System.out.println("Saldo insuficiente para saque.");
            return false;
        }
    }

    -

    public double getSaldo() {
        return this.saldo;
    }

    public String getNomeTitular() {
        return this.nomeTitular;
    }

    public String getNumeroConta() {
        return this.numeroConta;
    }
}
