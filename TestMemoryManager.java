//import TEST_LIB;


public class TestMemoryManager
{
   public static void main (String[] args)
   {
      //creates a size of 100 memory thing
      MemoryManager testmemory = new MemoryManager(100); 
      
      //requests for 1 part of memory
      MemoryAllocation request1 = testmemory.requestMemory(20, "requested1");
      assert request1.getPosition() == 0;
      assert request1.getOwner() == "requested1";
      assert request1.getLength() == 20;
      
      //requests again
      MemoryAllocation request2 = testmemory.requestMemory(10, "requested2");
      assert request2.getPosition() == 20;
      assert request2.getOwner() == "requested2";
      assert request2.getLength() == 10;
      
      //requests again
      MemoryAllocation request3 = testmemory.requestMemory(50, "requested3");
      assert request3.getPosition() == 30;
      assert request3.getOwner() == "requested3";
      assert request3.getLength() == 50;
      
      //requests again
      MemoryAllocation request4 = testmemory.requestMemory(20, "requested4");
      assert request4.getPosition() == 80;
      assert request4.getOwner() == "requested4";
      assert request4.getLength() == 20;
      
      //requests again
      MemoryAllocation request5 = testmemory.requestMemory(20, "requested5");
      assert request5 == null;
      
      //return memory
      testmemory.returnMemory(request2);
      testmemory.returnMemory(request3);
      
      MemoryAllocation request6 = testmemory.requestMemory(50, "requested6");
      assert request6.getPosition() == 20;
      assert request6.getOwner() == "requested6";
      assert request6.getLength() == 50;
      
      MemoryAllocation request8 = testmemory.requestMemory(8, "requested8");
      assert request8.getPosition() == 70;
      assert request8.getOwner() == "requested8";
      assert request8.getLength() == 8;
      
      MemoryAllocation request9 = testmemory.requestMemory(2, "requested9");
      assert request9.getPosition() == 78;
      assert request9.getOwner() == "requested9";
      assert request9.getLength() == 2;
      
      MemoryAllocation request7 = testmemory.requestMemory(11, "requested7");
      assert request7 == null;
      
      
      testmemory.returnMemory(request6);
      testmemory.returnMemory(request9);
      testmemory.returnMemory(request8);
      
      MemoryAllocation request10 = testmemory.requestMemory(60, "requested10");
      assert request10.getPosition() == 20;
      assert request10.getOwner() == "requested10";
      assert request10.getLength() == 60;
      
      testmemory.returnMemory(request1);
      testmemory.returnMemory(request4);
      
      MemoryAllocation request11 = testmemory.requestMemory(15, "requested11");
      assert request11.getPosition() == 0;
      assert request11.getOwner() == "requested11";
      assert request11.getLength() == 15;    
      
      MemoryAllocation request12 = testmemory.requestMemory(20, "requested12");
      assert request12.getPosition() == 80;
      assert request12.getOwner() == "requested12";
      assert request12.getLength() == 20; 
      
      testmemory.returnMemory(request10);
      testmemory.returnMemory(request11);
      testmemory.returnMemory(request12);
         
      
      
      
  

      






   }
}