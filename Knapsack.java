import java.util.Scanner;
import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;

public class Knapsack {


	//Class for the object items 
	public static class Item {
		
		String name;
		int weight;
		int value;

		public String getName() {
			return name;
		}

		public int getWeight() {
			return weight;
		}

		public int getValue() {
			return value;
		}

		public Item(String itemName, int itemWeight, int itemValue){
			name = itemName;
			weight = itemWeight;
			value = itemValue;
		}

	}

	//Reads items from file and creates an array of the objects 
	public static ArrayList<Item> importFile() {
		ArrayList items = new ArrayList();
		String directoryPath = "./knap_input.txt";
		String input = "";

		try (BufferedReader read = new BufferedReader(new FileReader(directoryPath))) {
			//Sets the object's value
			while ((input = read.readLine()) != null) {
				String itemName = input;
				int itemWeight = Integer.parseInt(read.readLine());
				int itemValue = Integer.parseInt(read.readLine());

				Item newItem = new Item(itemName, itemWeight, itemValue);
				items.add(newItem);

			}
		}
		catch (IOException e) {
			System.out.println("Error reading file.");
		}

		return (items);
	}

	//This creates what the output of the solution should be to terminal
	public static void generateSolution(String result, ArrayList<Item> items){
		
		System.out.println("Best set of items to take:");
		System.out.println("--------------------------");

		int bestValue = 0;
		int bestWeight = 0;

		for(int i=0; i<result.length(); i++) {

			char resultValue = result.charAt(i);
			String resultValueAsString = String.valueOf(resultValue);

			if(resultValueAsString.equals("1")) {
				System.out.println(items.get(i).getName());
				
				bestValue = bestValue + items.get(i).getValue();
				bestWeight = bestWeight + items.get(i).getWeight();


			}
		}
		
		System.out.println("--------------------------");
		
		System.out.println("Best Value: " + bestValue);

		System.out.println("Best Weight: " + bestWeight);
	}


	//This solves the knapsack problem 
	public static String whatShouldISteal(ArrayList<Item> input, int weight){
		String whatDidITake = "";
		String result = "";
		int totalValue = 0;
		int totalWeight = 0;

		//Gets the total number of possible combinations so we know when to stop the loop
		int totalCombinations = (int) Math.pow(2, input.size());

		for(int i=0; i<totalCombinations; i++) {
			//Sets this combination of items weight and value to zero initally
			int thisItemWeight = 0;
			int thisItemValue = 0;

			//Makes the binary of the interation we are on
			String binaryCombo = Integer.toBinaryString(i);

			//Makes an empty string for the number of zeros we need to add to the start of the string
			String addZeros = "";

			int numberOfZeros = 0;

			//Adds the necessary 0's to the string to create proper binary form
			if (binaryCombo.length() != input.size()) {
				numberOfZeros = (input.size())-(binaryCombo.length());
				for(int k=0; k<numberOfZeros; k++) {
					addZeros = addZeros + "0";
				}

				binaryCombo = addZeros + binaryCombo;
			}

			//Iterates over all combinations and updates totals for the specific knapsack goodies
			for (int j=0; j < input.size(); j++) {
				char binaryValue = binaryCombo.charAt(j);
				String binaryValueAsString = String.valueOf(binaryValue);
				if(binaryValueAsString.equals("1")) {
					thisItemValue = thisItemValue + input.get(j).getValue();
					thisItemWeight = thisItemWeight + input.get(j).getWeight();
				}
			}

			//Checks to see if it fits in the weight requirement and if the value is greater than the best option so far
			if ((thisItemWeight <= weight) && (thisItemValue >= totalValue)) {
				if(thisItemValue != totalValue){
					totalValue = thisItemValue;
					totalWeight = thisItemWeight;
					whatDidITake = binaryCombo;
					}
				else {
					if (thisItemWeight < totalWeight) {
						totalWeight = thisItemWeight;
						whatDidITake = binaryCombo;
					}
				}

			}

		}

		//returns the best option as a string 
		return whatDidITake;

	}

	public static void main(String[] args) {
		int weight = Integer.parseInt(args[0]);

		ArrayList<Item> knapsack = new ArrayList();
		knapsack = importFile();

		String whatYouStole = whatShouldISteal(knapsack, weight);

		generateSolution(whatYouStole, knapsack);

	}

}