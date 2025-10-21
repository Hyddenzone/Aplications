import java.util.Scanner;

public class terminal {

    public static void main(String[] args) {
      
        Scanner scanner = new Scanner(System.in);

        System.out.println("--- Bem-vindo ao Banco Clix ---");
        System.out.println("Vamos criar sua conta!");

        System.out.print("Digite o número da conta (ex: 1021): ");
        String numero = scanner.nextLine();

        System.out.print("Digite o nome do titular: ");
        String nome = scanner.nextLine();

        System.out.print("Deseja fazer um depósito inicial? (s/n): ");
        String resposta = scanner.nextLine();

        double depositoInicial = 0;
        if (resposta.equalsIgnoreCase("s")) {
            System.out.print("Digite o valor do depósito inicial: ");
            depositoInicial = scanner.nextDouble();
        }

       
        Conta minhaConta = new Conta(numero, nome, depositoInicial);

        System.out.println("\nConta criada com sucesso!");
        System.out.println("Titular: " + minhaConta.getNomeTitular());
        System.out.println("Conta: " + minhaConta.getNumeroConta());
        System.out.println("Saldo atual: R$" + minhaConta.getSaldo());

        
        int opcao = -1;
        while (opcao != 0) {
            System.out.println("\n--- Menu de Operações ---");
            System.out.println("1: Depositar");
            System.out.println("2: Sacar");
            System.out.println("3: Consultar Saldo");
            System.out.println("0: Sair");
            System.out.print("Escolha uma opção: ");

            opcao = scanner.nextInt();
            double valor; 

            switch (opcao) {
                case 1:
                    System.out.print("Digite o valor para depositar: ");
                    valor = scanner.nextDouble();
                    minhaConta.depositar(valor);
                    break;
                case 2:
                    System.out.print("Digite o valor para sacar: ");
                    valor = scanner.nextDouble();
                    minhaConta.sacar(valor);
                    break;
                case 3:
                    System.out.println("Saldo atual: R$" + minhaConta.getSaldo());
                    break;
                case 0:
                    System.out.println("Obrigado por usar o Banco Java. Até logo!");
                    break;
                default:
                    System.out.println("Opção inválida.");
            }
        }
        
        scanner.close();
    }
}
