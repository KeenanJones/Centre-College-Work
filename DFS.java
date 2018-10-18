import java.io.*;
import java.util.*;

public class DFS {

protected Stack whereHaveIBeen = new Stack();
protected boolean visitedHere[];
protected boolean done = false;
protected boolean nowDone = false;
protected boolean quitAlready = false;



	//Reads lines from file and creates an list of list
	public static int[][] makeArrayOfGraph(String fileName, int count) {
		int[][] graph = new int[count][count];
		String directoryPath = fileName;
		String line = "";

		try (BufferedReader read = new BufferedReader(new FileReader(directoryPath))) {
			int whatIsTheCount = 0;

			while ((line = read.readLine()) != null) {
				String[] splited = line.split(" ");

				int[] numbers = new int[splited.length];
				for(int i = 0;i < splited.length;i++)
				{
				   numbers[i] = Integer.parseInt(splited[i]);
				}

				graph[whatIsTheCount] = numbers;
				whatIsTheCount = whatIsTheCount + 1;
			}

		}

		catch (IOException e) {
			System.out.println("Error reading file.");
		}

		return (graph);
	}



	public DFS(int[][] graph){
		//Gets the length of the graph 

		int length = graph.length;
		boolean isThereACycle = false;

		//Makes a an array boolean the length of the graph to keep up with if each 
		//spot had been visited yet or not 
		// boolean[] visitedHere = new boolean[length];

		boolean nowDone = false;
	

		//Goes through all the vertices
		for(int i = 0; i < length; i++){
			boolean[] visitedHere = new boolean[length];

			//First checks to see if this vertex has been visited or not 
			if(visitedHere[i] != true){
				//If it has not been visited, visit it and mark it as true
				visitedHere[i] = true;

				//Check to see if there is a cycle from this vertex
				isThereACycle = solveCycle(graph, i, i, visitedHere);

				//If a cycle is found, print out the information
				if ((isThereACycle == true || nowDone == true) && quitAlready != true){
					System.out.println("CYCLE");
					

					String toPrint = "";
					int stackSize = whereHaveIBeen.size();
					String[] strings = new String[stackSize];
					String[] stringsRightOrder = new String[stackSize];

					for (int k = 0; k < stackSize; k++) {
						String theString = (String) whereHaveIBeen.pop().toString();
						strings[k] = theString;
						
					}

					int pos = stackSize - 1; 
					for (int l = 0; l < stackSize; l++){
						stringsRightOrder[l] = strings[pos];
						pos = pos - 1;
					}

					String[] printed = new String[stackSize];
					for (int well = 0; well < stackSize; well++){
						if(well == 0){
							String theString = stringsRightOrder[well];
							toPrint = toPrint + "-" + theString;
							printed[well] = theString;
						}
						else{
							boolean already = false;
							String theString = stringsRightOrder[well];
							for(int comeON = 0; comeON < printed.length; comeON++){
								if(printed[comeON] != null){

									if(printed[comeON].equals(theString) && nowDone == false){
										toPrint = toPrint + "-" + theString;
										already = true;
										nowDone = true;
										
									}
		
							}
						}
							if(already != true && nowDone == false){
								toPrint = toPrint + "-" + theString;
								printed[well] = theString;


							}
							else{
								System.out.println(toPrint.substring(1, toPrint.length() - 2));
								//System.out.println(toPrint.substring(1));
								quitAlready = true;
								break;
							}

						}

					}



				}
			}
		}

		//If it goes through all of this and doesnt find a cycle then print 
		if (isThereACycle == false){
			System.out.println("NO CYCLE");
		}

	}

	public boolean solveCycle(int[][] graph, int vertex, int parentVertex, boolean[] visitedHere){
		//Marks that we are visting the vertext
		visitedHere[vertex] = true;
		//Goes through all the adjacent vertices
		for (int i = 0; i < graph[vertex].length; i++) {
			if (graph[vertex][i] != 0) {
				if (i != parentVertex) {
					if (visitedHere[i] == true){
						whereHaveIBeen.push(vertex); 

						nowDone = true;
						return true;

					}

					else {

						whereHaveIBeen.push(vertex);
						solveCycle(graph, i, vertex, visitedHere);
						
					}
				}
			}
		}

		return false;

	}



	public static void main(String[] args) {
		//Gets the name of the file with the graph
		String fileName = args[0];
		boolean done = false;
		
		String input = "";
		int count = 0;
		//Just goes through and counts the number of lines so that max size of the lists can be known
		try (BufferedReader read = new BufferedReader(new FileReader(fileName))) {
			while ((input = read.readLine()) != null) {
				count = count + 1;
			}
		}
		catch (IOException e) {
			System.out.println("Error reading file.");
		}

		//Makes a new array of arrays to use as the graph
		int[][] arrayOfGraph = new int[count][count];
		arrayOfGraph = makeArrayOfGraph(fileName, count);

		//Calls the depth first search method on this array of array (graph)
		DFS getIt = new DFS(arrayOfGraph);
	
	}

}