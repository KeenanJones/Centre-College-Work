public class MemoryManager
{
   protected MemoryAllocation head;
    
   protected final String Free = "Free";
   
   long Size;
   
   long total;


    /* size- how big is the memory space.  
     *  Allways assume the position starts at 0
     *
     */
   public MemoryManager(long size)
   {
   Size=size;
   
   }



    /**
       takes the size of the requested memory and a string of the process requesting the memory
       returns a memory allocation that satisfies that request, or
       returns null if the request cannot be satisfied.
     */
    
   public MemoryAllocation requestMemory(long size,String requester)
   {
      if (head==null)
      {
         MemoryAllocation v0=new MemoryAllocation(requester,0,size,null,null);
         total += v0.getLength();
         head=v0;        
         return v0;     
      }
      else if(head!=null && head.getPosition()>=size && total<Size)
      {
        
         MemoryAllocation v0=new MemoryAllocation(requester,0,size,null,head);
         head=v0;
         total += v0.getLength();
         v0.next.prev=v0;
         return v0;  
      }
      else if(head!=null && head.getPosition()<size && head.next==null && total<Size)
      {                                                              //                  // 
         MemoryAllocation v0=new MemoryAllocation(requester,(head.getPosition() + head.getLength()),size,head,head.next); 
         head.next = v0;
         total += v0.getLength();
         return v0;
      }
      
      else if(head!=null && head.getPosition()<size && total<Size)
      {  
         MemoryAllocation pointer1=head;
         MemoryAllocation pointer2=head.next;
         while (((pointer2.getPosition()-(pointer1.getPosition() + pointer1.getLength())<size) && (pointer2.next != null) && (pointer1.next != null) && (pointer2 != null) && (pointer1 != null)))
         {  
            
            pointer1=pointer2;
            pointer2=pointer2.next;
            System.out.println("I am in a loop");
            
         }        
         if((pointer2.getPosition()-pointer1.getPosition()-pointer1.getLength())>=size && total<Size)
         {
          MemoryAllocation v0=new MemoryAllocation(requester,pointer1.getLength()+pointer1.getPosition(),size,pointer1,pointer2);
          total += v0.getLength();
          pointer2.prev=v0;
          pointer1.next=v0;
          return v0;
         } 
         else if((pointer2.getPosition() + pointer2.getLength())<Size && total<Size)
         {
          MemoryAllocation v0=new MemoryAllocation(requester,(pointer2.getPosition() + pointer2.getLength()),size,pointer2,pointer2.next);
          total += v0.getLength();
          pointer2.next = v0;
          return v0;
         }
      }
     
      return null;
      
   }


    
    /**
       takes a memoryAllcoation and "returns" it to the system for future allocations.
       Assumes that memory allocations are only returned once.       

     */
   public void returnMemory(MemoryAllocation mem)
   {
   
   if(mem.prev==null && mem.next==null)
   {
      total -= head.getLength();
      head = null; 
      
   }
      
   else if (head==mem)
   {
   total -= head.getLength();
   head=mem.next;
   mem.next.prev=null;
   mem.next=null;
   }
   else if(mem.next == null)
   {  
      total -= mem.getLength();
      mem.prev.next=null;
      mem.prev=null;
   }
   else
   {
   total -= mem.getLength();
   mem.next.prev=mem.prev;
   mem.prev.next=mem.next;
   mem.next=null;
   mem.prev=null;
   }
   }
    



}
